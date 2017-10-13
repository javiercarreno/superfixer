# Superfixer
A command-line tool to run php-cs-fixer and behat indentation fix on modified git files

# Installation
* Clone the repository in your prefered source code folder with ``git clone git@github.com:javiercarreno/superfixer.git``
* Add executing permissions to superfixer file ``chmod +x superfixer``
* Add alias to your prefered terminal application to path, for example: ``alias superfix="/Users/{user}/src/superfixer/superfixer"``
* Close terminal and reopen to reload the alias.

# Usage
* Enter into the folder with git repository which have modified files to fix.
* Ensure that there are php or behat files to fix (git status).
* Run superfix.