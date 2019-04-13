VERSION 1.1.4:
- Update extension Instant Search
- Fix style issue of Mageplaza Onestep Checkout

If you are using version 1.13 and want to update to version 1.1.4, please follow our steps:
- upload app folder to your magento root folder
- run command: php bin/magento module:enable MGS_InstantSearch
- run command: php bin/magento setup:upgrade
- remove var/*
- remove pub/static/frontend/Mgs
- run deploy command: php bin/magento setup:static-content:deploy

If you are new. Please ignore this patch.