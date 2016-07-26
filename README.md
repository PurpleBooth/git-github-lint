# Git GitHub Lint

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/PurpleBooth/git-github-lint/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/PurpleBooth/git-github-lint/?branch=master)
[![Build Status](https://travis-ci.org/PurpleBooth/git-github-lint.svg?branch=master)](https://travis-ci.org/PurpleBooth/git-github-lint)
[![Dependency Status](https://www.versioneye.com/user/projects/579afcf63815c8005161534d/badge.svg?style=flat-square)](https://www.versioneye.com/user/projects/579afcf63815c8005161534d)
[![Latest Stable Version](https://poser.pugx.org/purplebooth/git-github-lint/v/stable)](https://packagist.org/packages/purplebooth/git-github-lint)
[![License](https://poser.pugx.org/purplebooth/git-github-lint/license)](https://packagist.org/packages/purplebooth/git-github-lint)

This project is designed to ensure that the commits you're making to a
repository follow the git coding style. This is the library component
with no web frontend.

## Getting Started

### Prerequisities

You'll need to install:

 * PHP (Minimum 7.0)

### Installing

```
composer require PurpleBooth/git-github-lint
```

## Usage

You can use the whole library

```php
<?php

$gitHubClient = new \Github\Client()

/** @var GitHubLint $gitHubLint **/
$gitHubLint = new GitHubLintImplementation($gitHubClient);
$gitHubLint->analyse('PurpleBooth', 'git-github-lint', 1);
// -> The commits on your PR should now be updated with a status
```

Alternatively you could use the validators alone

```php
<?php

$messageValidator new ValidateMessagesImplementation(
    new ValidateMessageImplementation(
        [
            new CapitalizeTheSubjectLineValidator(),
            new DoNotEndTheSubjectLineWithAPeriodValidator(),
            new LimitTheBodyWrapLengthTo72CharactersValidator(),
            new LimitTheTitleLengthTo69CharactersValidator(),
            new SeparateSubjectFromBodyWithABlankLineValidator(),
            new SoftLimitTheTitleLengthTo50CharactersValidator(),
        ]
    )
);


$message
    = <<<MESSAGE
This is an example title

This is a message body. This is another part of the body.
MESSAGE;

$exampleMessage = new MessageImplementation("exampleSha", $message);

$messageValidator->validate([$exampleMessage]);
// -> Message Objects will now have a Status set on them
```

Please depend on the interfaces rather than the concrete
implementations. Concrete implementations may change without causing a
BC break, interfaces changing will cause major version increment,
indicating a BC break.

## Running the tests

To run the tests for coding style

First checkout the library, then run

```bash
composer install
```

### Coding Style

We follow PSR2, and also enforce PHPDocs on all functions

```bash
vendor/bin/phpcs -p --standard=psr2 src/ spec/
```

### Unit tests

We use PHPSpec for unit tests

```bash
vendor/bin/phpspec run
```

## Contributing

Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details on our code
of conduct, and the process for submitting pull requests to us.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions
available, see the [tags on this repository](https://github.com/purplebooth/git-github-lint/tags).

## Authors

See the list of [contributors](https://github.com/purplebooth/git-github-lint/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
