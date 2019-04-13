VERSION 1.1.0:
- Update new homepage layouts: classic, metro, simple
- Update option for parallax footer
- Update Category Landing pages
- Fix register issue

If you are using old version and want to update from version 1.0.3 to version 1.1.0, please follow our steps:
- upload two folders app and lib to your magento root folder
- upload ../patch_for_magento_2.2+/app to your magento root folder (if you are using magento 2.2.0)
- remove: app/design/frontend/Mgs/unero/web/js/theme.js
- remove: app/design/frontend/Mgs/unero/Magento_Catalog/page_layout/1column.xml 
- run command: php bin/magento module:enable MGS_Landing
- run command: php bin/magento setup:upgrade
- remove var/*
- remove pub/static/frontend/Mgs/claue
- run deploy command: php bin/magento setup:static-content:deploy
- run reindex command: php bin/magento indexer:reindex
- go to admin > MGS > [MGS Theme] Theme Setting and "Save Config" again.

If you are new. Please ignore this patch.