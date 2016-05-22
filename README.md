# SilverStripe Release Notifications

[![Build Status](https://api.travis-ci.org/FriendsOfSilverStripe/release-notifications.svg?branch=master)](https://travis-ci.org/FriendsOfSilverStripe/release-notifications)
[![Latest Stable Version](https://poser.pugx.org/FriendsOfSilverStripe/release-notifications/version.svg)](https://github.com/FriendsOfSilverStripe/release-notifications/releases)
[![Latest Unstable Version](https://poser.pugx.org/FriendsOfSilverStripe/release-notifications/v/unstable.svg)](https://packagist.org/packages/FriendsOfSilverStripe/release-notifications)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/FriendsOfSilverStripe/release-notifications.svg)](https://scrutinizer-ci.com/g/FriendsOfSilverStripe/release-notifications?branch=master)
[![Total Downloads](https://poser.pugx.org/FriendsOfSilverStripe/release-notifications/downloads.svg)](https://packagist.org/packages/FriendsOfSilverStripe/release-notifications)
[![License](https://poser.pugx.org/FriendsOfSilverStripe/release-notifications/license.svg)](https://github.com/FriendsOfSilverStripe/release-notifications/blob/master/license.md)

This little helper sends [notification emails](https://github.com/FriendsOfSilverStripe/release-notifications "release notification emails from SilverStripe") out, if your CHANGELOG-file *has* changed.

## Requirements

 * SilverStripe Framework 3.x
 * a plain-text CHANGELOG.md file in your website source code, during the deployment.

## Installation

````bash
composer require FriendsOfSilverStripe/release-notifications
````

## Configuration

e.g. mysite/_config/config.yml:

````yaml
# send the release notification to the team and stakeholders
ReleaseNotification:
  environments:
    test1:
      environment_name: test1
      url: 'http://test1.company.com/'
      filename: CHANGELOG.md
      from: dev-team@company.com
      subject: New Release (TEST)
      recipients:
        - qa-team@company.com
    production:
      environment_name: production
      url: 'http://company.com/'
      filename: CHANGELOG.md
      from: info@company.com
      subject: New Release
      recipients:
        - info@company.com
````

## MISC: [Future ideas/development, issues](https://github.com/FriendsOfSilverStripe/release-notifications/issues), [Contributing](https://github.com/FriendsOfSilverStripe/release-notifications/blob/master/CONTRIBUTING.md), [License](https://github.com/FriendsOfSilverStripe/release-notifications/blob/master/license.md)