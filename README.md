Hadori Demo
===========
Symfony Release 1.4.11

In order to get this project off the ground, follow these steps:

Symlink your symfony core library directory.  If you do not have the core symfony library on your machine, you'll need to export it first.

      # Export the symfony release if you do not already have it
      $ svn export http://svn.symfony-project.com/tags/RELEASE_1_4_11 /usr/local/lib/symfony/RELEASE_1_4_11
      # Symlink in lib/vendor directory
      $ ln -s /usr/local/lib/symfony/RELEASE_1_4_11 lib/vendor/symfony

Init your git submodules

      $ git submodule init
      $ git submodule update

Copy config/database.yml.dist to config/database.yml and configure the file with the proper credentials

      $ cp config/databases.yml.dist config/databases.yml

Afer you configure your database, have doctrine set up tables and fixtures with the "build" command

      $ php symfony doctrine:build --all --and-load

Fix permissions for good measures
     
      $ php symfony project:permissions

And as always, publish them assets!

      $ php symfony plugin:publish-assets 
