# Contributing

You are very welcome to contribute to this project by giving constructive criticism, feedback, creating issues and
submitting pull requests.

Each contribution is appreciated.

## Areas of Focus

Every aspect of this project from documentation to actual code is subject for improvement.

However, due to the security aspect we would like to strongly encourage reviews of the implementations of the
encryption and decryption processes. This also includes the choice of supported ciphers and modes.

## Bug Reports

Bugs may be reported in the project issue tracker.

Bug reports should include information on

*   the version of the Symfony framework
*   the version of the ParameterEncryptionBundle
*   the version of a potentially affected add-on bundle (like ParameterEncryptionDefuseBundle)
*   instructions on how to reproduce the problem
*   the expected behavior
*   the actual behavior

We may also ask for sample code in a fresh project based on the
[Symfony Standard Edition](https://github.com/symfony/symfony-standard) if we cannot simulate it otherwise.
Ideally, this would be as easy as cloning a repository and following a couple of steps.

## Contributing Code

Please make sure that the documentation is still up to date and not missing any vital information relating to your
changes!

### Before Submitting a Pull Request

In order to maintain a certain quality level for the code, this project is using several tools to help with testing and
coding standards.

The following steps are required:

*   All tests have to execute successfully.

*   Check the code coverage in order to stay at 100%:

    ```console
    $ composer test-coverage
    ```

    or

    ```console
    $ ./vendor/bin/phpunit -v --coverage-text
    ```

*   Run PHP CS Fixer for coding standards / code style:

    ```console
    $ composer cs
    ```

    or

    ```console
    $ ./vendor/bin/php-cs-fixer fix -v --dry-run --diff
    ```

Automated versions of these checks will run during the build process.

Any errors will make the build fail.

You can find links to the results of the build process and the code coverage at the top of the [README](README.md).
