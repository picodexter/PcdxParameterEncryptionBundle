CLI Commands
============

For Symfony 2.x the commands begin with

.. code-block:: terminal

    $ php app/console

instead of

.. code-block:: terminal

    $ php bin/console

Encrypt
-------

Encrypt a value.

.. code-block:: terminal

    $ php bin/console pcdx-parameter-encryption:encrypt <algorithm ID> [plaintext value] [<--key|-k> [key]] [<--quiet|-q>]

Will prompt for plaintext value if none is provided.

Automatically assumes configured encryption key if none is provided.

Reduces output to encrypted value in quiet mode.

Decrypt
-------

Decrypt a value.

.. code-block:: terminal

    $ php bin/console pcdx-parameter-encryption:decrypt <algorithm ID> [encrypted value] [<--key|-k> [key]] [<--quiet|-q>]

Will prompt for encrypted value if none is provided.

Automatically assumes configured decryption key if none is provided.

Reduces output to decrypted value in quiet mode.

List Algorithms
---------------

List configured algorithms with their IDs and their encrypter and decrypter service names.

.. code-block:: terminal

    $ php bin/console pcdx-parameter-encryption:algorithm:list
