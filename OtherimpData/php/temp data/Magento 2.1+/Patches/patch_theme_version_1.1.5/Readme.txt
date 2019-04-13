VERSION 1.1.5:
- Update builder new version
- Update cms pages builder
- Improve speed load
- Update thumbnail for headers and footers
- Support for style of Webkul_Marketplace extension

If you are using version 1.1.4 and want to update to version 1.1.5, please follow our steps:
- remove pub\media\mgs\unero\headers
- upload 2 folders app and pub to your magento root folder
- run command: php bin/magento setup:upgrade
- remove var/*
- remove pub/static/frontend/Mgs
- run deploy command: php bin/magento setup:static-content:deploy
- login to front-end with front-end builder account
- active builder
- go to homepage
- click "Confirm" button on top panel. If you are using multiple homepages for multiple store views. You need to create cms page (admin > Content > Pages) for each homepage and go to front-end, switch each store view and click "Confirm" button.

If you are new. Please ignore this patch.