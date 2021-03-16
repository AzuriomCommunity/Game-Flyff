# How to install

### Prequisites
- A working Flyff server
- A working Webserver (apache, nginx)

You can then follow the wiki : https://github.com/AzuriomCommunity/Game-Flyff/wiki

## Updates
Only If you used the plugin before and the current plugin version is below 0.2.3 : 
- You should add one column `Azuriom_user_access_token` of type `varchar(191)` and allow null values

# Advanced

 ### Salt for password
 
 You can change the default salt of 'kikugalanet' in your .env (root folder of azuriom)

Simply past this inside:
 `MD5_HASH_KEY=my-new-salt`

# Support/Questions
Feel free to contact me on discord `Jav#7775`
