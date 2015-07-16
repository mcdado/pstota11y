# Tota11y by Khan Academy

<img src="http://khan.github.io/tota11y/img/tota11y-logo.png" alt="tota11y logo" width="200">

## Credits

tota11y is an accessibility visualization toolkit from your friends at [Khan Academy](http://khanacademy.org/).

This module is put together by [David Gasperoni](https://github.com/mcdado).
**IMPORTANT**: This module is not affiliated with Khan Academy.

Many of tota11y's features come straight from [Google Chrome's Accessibility Developer Tools](https://github.com/GoogleChrome/accessibility-developer-tools).

The awesome glasses in the logo were created by [Kyle Scott](https://thenounproject.com/Kyle/) and are licensed under [CC BY 3.0](http://creativecommons.org/licenses/by/3.0/us/legalcode).

# How to install

If you want a zip file to upload to your PrestaShop installation, simply run `source build.sh` on your terminal and a file will be created in the `dist` directory. Everytime you run this command, the file `dist/tota11yps-latest.zip` will be overwritten with the current state of the module.

If you want to keep the repo in a directory and easily copy the module files to a local installation of PrestaShop, you could use the command `source stage.sh`; it's IMPORTANT to first create a file called `.prestashop-local-testing.sh` in your home directory with the following code:

    COUNTER=0
    echo "Locally deploying for $(whoami)"
    rsync -a --delete-excluded --exclude-from=.rsyncrc $(pwd) ~/Sites/prestashop16014/modules/ && COUNTER=$((COUNTER+1))
    rsync -a --delete-excluded --exclude-from=.rsyncrc $(pwd) ~/Sites/prestashop1610/modules/ && COUNTER=$((COUNTER+1))
    echo "Deployment complete in $COUNTER projects"

You need to change the lines above to match your local setup, to point to your local installations.
