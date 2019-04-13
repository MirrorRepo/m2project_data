VERSION 1.1.1:
- Update option for hide newsletter popup form for magento 2
- Fix issue when use builder to save blocks for magento 2

If you are using old version and want to update from version 1.1.0 to version 1.1.1, please follow our steps:
- upload app folder to your magento root folder
- remove var/*
- remove pub/static/frontend/Mgs
- run deploy command: php bin/magento setup:static-content:deploy


If you are new. Please ignore this patch.