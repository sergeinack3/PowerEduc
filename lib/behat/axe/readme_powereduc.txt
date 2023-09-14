Description of axe import into PowerEduc

1/ Download the latest axe code somewhere (example /tmp/axe) using:
npm install axe-core --save-dev
Note down the version number displayed by the command, to update lib/thirdpartylibs.xml accordingly.


2/ Copy the following file to your local PowerEduc directory, to replace the old one:
cp node_modules/axe-core/axe.min.js [PATH TO YOUR POWEREDUC]/lib/behat/axe/


3/ Run behat tests labelled with @accessibility and confirm they are passing with the new library version, or fix the failures
because the new version might raise issues that weren't detected previously:
php admin/tool/behat/cli/init.php --axe
php admin/tool/behat/cli/run.php --tags=@accessibility
