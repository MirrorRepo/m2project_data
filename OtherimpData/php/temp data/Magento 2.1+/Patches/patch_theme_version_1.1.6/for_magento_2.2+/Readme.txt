VERSION 1.1.6:
- Fix product gallery issue for magento 2.2+
- Fix instagram feed issue

If you are new or your magento version is magento 2.1.x. Please ignore this patch.

- remove var/*
- remove pub/static/frontend/Mgs
- run deploy command: php bin/magento setup:static-content:deploy -f