# PcdxParameterEncryptionBundle

This bundle lets you save Symfony parameters in an encrypted form and
automatically decrypt them during runtime.

[![Latest Stable Version](https://img.shields.io/packagist/v/picodexter/parameter-encryption-bundle.svg?style=flat)](https://packagist.org/packages/picodexter/parameter-encryption-bundle)
[![Build Status](https://img.shields.io/travis/picodexter/PcdxParameterEncryptionBundle/master.svg?style=flat)](https://travis-ci.org/picodexter/PcdxParameterEncryptionBundle)
[![Code Coverage](https://img.shields.io/coveralls/picodexter/PcdxParameterEncryptionBundle/master.svg?style=flat)](https://coveralls.io/github/picodexter/PcdxParameterEncryptionBundle)

## Purpose

### What It Does

This bundle allows developers to save sensitive information in Symfony
parameters in an encrypted form so that it can be committed to a VCS. The only
remaining sensitive information, the decryption key, could then be saved in an
unversioned `parameters.yml` file or simply passed in an environment variable.

Through this approach you can easily keep all stage-specific configuration
files in the VCS and use a switch mechanism to detect which one to load. This
helps you keep the number of stage-specific (automatically) deployed but
unversioned files to an absolute minimum.

### What It Does Not Do

The intention is **not** to provide security in a way that an attacker with
access to the webspace file system wouldn't be able to decrypt the parameters.

The PHP process needs to read both the encrypted data as well as the decryption
key(s), be it in the file system or in memory as an environment variable.
Someone who manages to infiltrate the process therefore automatically gains
relevant read access to both pieces of information as well.

Additionally, anyone who can read the Symfony application cache would be able
to extract the dumped container including all decrypted parameters anyway.

## Documentation

The documentation source files are located in the `Resources/doc/` directory of
this bundle.

## Installation

Please refer to the [Getting Started guide](Resources/doc/getting-started.rst).

## License

This bundle is released under the [MIT license](LICENSE).
