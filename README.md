# lalalytics.com TYPO3 Extension

![lalalytics.com logo](https://lalalytics.com/images/lalalytics.svg) for ![typo3 logo](https://zimmer7.com/fileadmin/Images/Logos/Marken/TYPO3.svg)

This extension integrates lalalytics with your TYPO3 installation. lalalytics is a simple and fun to use Google Analytics alternative.

## Installation

1. [Create an account](https://lalalytics.com/login/register?utm_campaign=github&utm_medium=web&utm_source=readme)
1. Add new site to your account
1. Go to settings and grab your key
1. Install TYPO3 Extension `composer require zimmer7/lalalytics`
1. Configure
1. Enjoy

## Configuration

Go to `Site Management > Site > Edit Site > Languages > lalalytics (Tab) > Enable`

OR

Go directly to your `config.yaml` and add your config

```yaml
[...]
languages:
  - title: Deutsch
    enabled: true
    [...]
    lalalytics_enabled: true           # true|false
    lalalytics_code: <YOUR SITE CODE>  # find your code on lalalytics.com > site > site settings > snippet
    lalalytics_proxy: true             # true|false, keep in sync with lalalytics.com > site > site settings > proxy
    lalalytics_filterip: true          # filter IPs before forwarding request
[...]
```

## Features

lalalytics is

- easy to setup,
- does not collect or share personal information,
- does not use cookies,
- respect user's privacy,
- is GDPR compliant.
- It helps your understand your visitors,
- keep track of the most relevant metrics,
- filter your stats,
- create interesting reports and share with your team.

lalalytics TYPO3 extension helps you

- integrate lalalytics,
- add custom tracking events on the fly,
- proxy tracking requests through your server and
- helps you filter IPs before forwarding requests and
- therefore it helps you avoid annoying cookie banners.

## Requirements

- TYPO3 v11-v12
- PHP v8.1-8.3
- [lalalytics account](https://lalalytics.com/login/register?utm_campaign=github&utm_medium=web&utm_source=readme)
  - Use the 30 day trial period to build your integration
  - get a feel for the integration and
  - then decide for a plan.
