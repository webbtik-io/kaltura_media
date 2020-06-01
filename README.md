Media Entity Kaltura
====================

# Introduction

This module allows you to use [Kaltura](https://corp.kaltura.com) into your Drupal 8 site.

This module provides the following:
- Kaltura Field Type (with field widget and field formatter)
- Kaltura theme hook to render playe
- Kaltura Media source to create media entity type

With this module you can create a new Media Entity Type using the provided
source and then be able to use Kaltura integrated into your media library.

# How to use?

Create a new media entity type using the provided source. This will
automatically add the provided field type to the media type. Now, when you
create a Media entity of that type, you'll be required to provide the 3 needed
Kaltura elements: partnerId, uiconfId and entry_id. They will be used to embed
the Kaltura player into your page when this media entity is displayed.

# Compatibility

This module should be used with the Media module in Drupal core and should be
compatible with both Drupal 8.8 and Drupal 9.

# Supporting organizations

[Evolving Web](https://www.drupal.org/evolving-web) Initial development.