# How to install

### Prequisites
- A working Flyff server
- A working Webserver (apache, nginx)

### Database
- [Change SQL Server Authentication to mixe](https://www.google.com/search?q=Change+SQL+Server+Authentication+Mode) and restart the SQL Server
- Create a user with a password and replace "MyNewAdminUser" and "abcd"

```sql
USE [master];
GO
CREATE LOGIN MyNewAdminUser 
    WITH PASSWORD    = N'abcd',
    CHECK_POLICY     = OFF,
    CHECK_EXPIRATION = OFF;
GO
EXEC sp_addsrvrolemember 
    @loginame = N'MyNewAdminUser', 
    @rolename = N'sysadmin';
```
- Download php extensions : [sqlsrv](https://pecl.php.net/package/sqlsrv/5.8.1/windows) and [pdo_sqlsrv](https://pecl.php.net/package/pdo_sqlsrv/5.8.1/windows) to place the .dll in the extension folder of your php (ext). Becarefull about the x64 and x86 part and make sure they are enabled in the php.ini

### CMS
- Download the CMS : [https://azuriom.com/en/download](https://azuriom.com/en/download)
- Unzip the files in your webserver then go to `my-site.com/install.php`
- Follow the steps
 
### Flyff plugin
- Login into your website, then go to the admin panel
- In the plugin section, search for Flyff, download and enable the plugin.
- Now go to the Servers section and add a Flyff server (default port for WorldServer is 29000)


# Advanced

### In-game Shop

This part is a little bit more tricky and before going any further you should try to be familiar with the CMS.

It requires a theme (which you can download in the admin panel). The theme should be a starter to make your own theme.
[see Azuriom docs about themes](https://azuriom.com/en/docs/themes)

Go to the [Flyff-Theme Github](https://github.com/AzuriomCommunity/Flyff-Theme/blob/master/README.md) to see how to modify your Flyff sources

 ### Salt for password
 
 You can change the default salt of 'kikugalanet' in your .env for exemple `MD5_HASH_KEY=my-new-salt`
