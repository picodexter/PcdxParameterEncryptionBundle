Getting Started
===============

Prerequisites
-------------

You need Symfony 2.7+.

Installation
------------

Step 1: Download the Bundle
~~~~~~~~~~~~~~~~~~~~~~~~~~~

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

.. code-block:: terminal

    $ composer require picodexter/parameter-encryption-bundle "~1"

This command requires you to have Composer installed globally, as explained
in the `installation chapter`_ of the Composer documentation.

Step 2: Enable the Bundle
~~~~~~~~~~~~~~~~~~~~~~~~~

Then, enable the bundle by adding it to the list of registered bundles
in the ``app/AppKernel.php`` file of your project:

.. code-block:: php

    <?php
    // app/AppKernel.php

    // ...
    class AppKernel extends Kernel
    {
        public function registerBundles()
        {
            $bundles = array(
                // ...

                new Picodexter\ParameterEncryptionBundle\PcdxParameterEncryptionBundle(),
            );

            // ...
        }

        // ...
    }

Step 3: Configuration
~~~~~~~~~~~~~~~~~~~~~

Example:

In this example we will be looking at using the Caesar cipher as the encryption
algorithm (which comes by default with this bundle), specifically with a
rotation of 13 (ROT13).

As this type of encryption does not use any key, supplying one is pointless,
however it is still shown in order to convey the main concept.

1.  Application configuration:

    .. configuration-block::

        .. code-block:: yaml

            # app/config/config.yml
            pcdx_parameter_encryption:
                algorithms:
                    -   id: 'caesar_rot13'
                        pattern:
                            type: 'value_prefix'
                            arguments:
                                -   '=#!PPE!c:r13!#='
                        encryption:
                            service: 'pcdx_parameter_encryption.encryption.encrypter.caesar.rot13'
                            key: '%parameter_encryption.caesar.rot13.key%'
                        decryption:
                            service: 'pcdx_parameter_encryption.encryption.decrypter.caesar.rot13'
                            key: '%parameter_encryption.caesar.rot13.key%'

        .. code-block:: xml

            <!-- app/config/config.xml -->
            <?xml version="1.0" encoding="UTF-8" ?>
            <container xmlns="http://symfony.com/schema/dic/services"
                xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                xmlns:ppe="https://picodexter.io/schema/dic/pcdx_parameter_encryption"
                xsi:schemaLocation="https://picodexter.io/schema/dic/pcdx_parameter_encryption
                    https://picodexter.io/schema/dic/pcdx_parameter_encryption/pcdx_parameter_encryption-1.0.xsd">

                <ppe:config>
                    <ppe:algorithm id="caesar_rot13">
                        <ppe:pattern type="value_prefix">
                            <ppe:argument>=#!PPE!c:r13!#=</ppe:argument>
                        </ppe:pattern>
                        <ppe:encryption service="pcdx_parameter_encryption.encryption.encrypter.caesar.rot13">
                            <ppe:key>%parameter_encryption.caesar.rot13.key%</ppe:key>
                        </ppe:encryption>
                        <ppe:decryption service="pcdx_parameter_encryption.encryption.decrypter.caesar.rot13">
                            <ppe:key>%parameter_encryption.caesar.rot13.key%</ppe:key>
                        </ppe:decryption>
                    </ppe:algorithm>
                </ppe:config>
            </container>

        .. code-block:: php

            // app/config/config.php
            $container->loadFromExtension(
                'pcdx_parameter_encryption',
                [
                    'algorithms' => [
                        [
                            'id' => 'caesar_rot13',
                            'pattern' => [
                                'type' => 'value_prefix'
                                'arguments' => ['=#!PPE!c:r13!#='],
                            ],
                            'encryption' => [
                                'service' => 'pcdx_parameter_encryption.encryption.encrypter.caesar.rot13',
                                'key' => '%parameter_encryption.caesar.rot13.key%',
                            ],
                            'decryption' => [
                                'service' => 'pcdx_parameter_encryption.encryption.decrypter.caesar.rot13',
                                'key' => '%parameter_encryption.caesar.rot13.key%',
                            ],
                        ],
                    ],
                ]
            );

2.  Parameters:

    .. configuration-block::

        .. code-block:: yaml

            # app/config/parameters.yml
            parameters:
                parameter_encryption.caesar.rot13.key: 'not necessary for the Caesar cipher'

        .. code-block:: xml

            <!-- app/config/parameters.xml -->
            <?xml version="1.0" encoding="UTF-8" ?>
            <container xmlns="http://symfony.com/schema/dic/services"
                xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                xsi:schemaLocation="http://symfony.com/schema/dic/services
                    http://symfony.com/schema/dic/services/services-1.0.xsd">

                <parameters>
                    <parameter key="parameter_encryption.caesar.rot13.key">not necessary for the Caesar cipher</parameter>
                </parameters>
            </container>

        .. code-block:: php

            // app/config/parameters.php
            $container->setParameter('parameter_encryption.caesar.rot13.key', 'not necessary for the Caesar cipher');

Step 4: Test
~~~~~~~~~~~~

1.  Generate an encrypted value via :doc:`/cli`

2.  Save the value as a parameter with the configured prefix.

    Example (based on example configuration shown above):

    *   Plaintext value: ``This is a test``
    *   Encrypted value: ``Guvf vf n grfg``
    *   Save as a parameter with the value: ``=#!PPE!c:r13!#=Guvf vf n grfg``

3.  Read the parameter via code.

Step 5: Use Other Encryption Algorithms
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

There are currently two ways to get other encryption algorithms (apart from the
one contained in this bundle) to work:

1.  Get and install an add-on bundle.

    See :doc:`/supported-algorithms`.

2.  Code your own.

    1.  Implement the :class:`Picodexter\ParameterEncryptionBundle\Encryption\Decrypter\DecrypterInterface`
        and the :class:`Picodexter\ParameterEncryptionBundle\Encryption\Encrypter\EncrypterInterface`
        respectively.

    2.  Add Symfony services for the newly implemented classes.

    3.  Add an algorithm entry in the bundle configuration.
        See :doc:`/configuration`.

.. _installation chapter: https://getcomposer.org/doc/00-intro.md
