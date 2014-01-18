CKAN Consumer
=============

PHP implementation of a [CKAN][ckan] consumer library.

This implementation is based on the [CKAN v2.2a documentation][docs].

The goal of this library is to provide a nice, sane and uniform interface for the CKAN API.

####Installation

######Git:

    $ git clone https://github.com/PeeHaa/CkanConsumer.git

######Manual Download:

Manually download from the [tagged release section][tagged].

######Composer:

Add the following to your composer config file:

    {
        "require": peehaa/ckanconsumer:0.0.*
    }

####Requirements

This library runs on all officially supported PHP versions and HHVM.

####Contributing

- All pull requests must have 100% code coverage
- All pull requests must conform to PSR-2
- All pull requests must not have failing tests
- Commits must be squashed before sending over a pull requests where needed

####Version

This library uses [semantic versioning 2.0.0][semver].

The current version of this library is 0.0.1

####License

[MIT License (MIT)][mit]

[ckan]: http://ckan.org/
[docs]: http://docs.ckan.org/en/latest/index.html
[tagged]: https://github.com/PeeHaa/CkanConsumer/releases
[semver]: http://semver.org/
[mit]: http://spdx.org/licenses/MIT
