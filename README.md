## INTRODUCTION

Adds configurable at protocol dids at /.well-known/atproto-did per domain in order to use the domain as a handle on Bluesky.
Note: these are config entities so will export with site configuration.
If you wish to configure only on a live site and avoid these being removed by deployments, install the [Config ignore](https://www.drupal.org/project/config_ignore) module and on /admin/config/development/configuration/ignore add the following:
```
atproto_did.atproto_did.*
```

## REQUIREMENTS

Drupal 10 or 11.

## INSTALLATION

Install as you would normally install a contributed Drupal module.
See: https://www.drupal.org/node/895232 for further information.

## CONFIGURATION

Configure at protocol dids at /admin/config/services/atproto-did.
In order for this module to respond with the configured domain did, the domain needs to point to the Drupal website.

## MAINTAINERS

Current maintainers for Drupal 10+:

- Andy Broomfield (andybroomfield) - https://www.drupal.org/u/andybroomfield