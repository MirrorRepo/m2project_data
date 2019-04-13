VERSION 1.0.1:
- Fix reindex data issue for magento 2.2.0
- Support style for IWD Checkout Suite extension (Magento 2)

If you are using version 1.0.0 and want to update to theme version 1.0.1, please follow our steps:
- upload app folder to your magento root folder
- remove var/*
- remove pub/static/frontend/Mgs/unero
- run upgrade command: php bin/magento setup:upgrade
- run deploy command: php bin/magento setup:static-content:deploy
- run reindex data command: php bin/magento indexer:reindex

If you are new. Please ignore this patch.