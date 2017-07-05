Frequently Asked Questions
==========================

How does this bundle impact the performance of my Symfony application?
----------------------------------------------------------------------

The main mechanism that this bundle is utilizing is a compiler pass for the Symfony kernel. Once the kernel has executed
the compiler passes and this bundle has decrypted all encrypted values, usually the container is dumped into the
application cache. Consecutive requests will be served from the cache with the dumped, compiled container.

In a way, the decryption logic of this bundle is only executed whenever the application cache needs to be refreshed.

This bundle focuses on encryption. Is this really secure?
---------------------------------------------------------

The intention is **not** to provide security in a way that an attacker with access to the webspace file system would not
be able to decrypt the parameters.

The PHP process needs to read both the encrypted data as well as the decryption key(s), be it in the file system or
in memory as an environment variable. Someone who manages to infiltrate the process therefore automatically gains
relevant read access to both pieces of information as well.

Additionally, anyone who can read the Symfony application cache would be able to extract the dumped container including
all decrypted parameters anyway.

In terms of the encryption algorithms themselves, this bundle only relies on third-party encryption libraries that are
reputable, well-tested and have proven themselves over time. It does not implement any kind of encryption algorithm
by itself - with the exception of the Caesar cipher that serves as an example implementation / proof of concept.

With the upcoming release of PHP 7.2 hopefully there will be additional ways to use secure encryption algorithms
natively via PHP core functionality.

Is it possible to chain different encryptions / algorithms?
-----------------------------------------------------------

While originally not intended, it is possible that a decrypted value consists of an encrypted value of an algorithm
that is executed after the first one, enabling chained encryption.

The algorithms are executed in the order in which they are configured.

However, even though it is possible right now, there is no guarantee that this will stay as a feature. In fact, the
overall benefit of this approach is questionable if not convoluted and it could be more sensible to answer the
question of "why" behind this choice in a different way.

Why does bundle XYZ not get the decrypted values passed as its configuration?
-----------------------------------------------------------------------------

Symfony resolves parameters for bundle configurations before it executes any other compiler passes, including the one
that is responsible for replacing encrypted parameter values with their decrypted counterparts. That is the reason
why the Bundle Configuration Service Definition Rewriting feature exists.

See :doc:`/bundle-configuration-service-definition-rewriting` for more information about the topic.
