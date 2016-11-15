# phan_example_project
Example phan project using the forked https://github.com/TysonAndre/phan

This exists to test experimental magic properties and superglobal features

## Running phan analysis

Run `./install.sh` to download the phan fork(and analyze the codebase)

After the initial installation, run `./phan/phan` to generate output.

The output for [src/magic_properties_and_globals.php](src/magic_properties_and_globals.php) is currently below.

Assignment of possibly incompatible types to globals/superglobals still needs to be detected.

```
src/magic_properties_and_globals.php:78 PhanTypeMismatchProperty Assigning \stdClass to property but \RunkitGlobal::stringVar is string
src/magic_properties_and_globals.php:80 PhanTypeMismatchArgumentInternal Argument 1 (string) is string[] but \strlen() takes string
src/magic_properties_and_globals.php:85 PhanTypeMismatchProperty Assigning int to property but \RunkitGlobal::dateVar is \DateTime
src/magic_properties_and_globals.php:87 PhanTypeMismatchArgumentInternal Argument 1 (numerator) is string but \intdiv() takes int
src/magic_properties_and_globals.php:91 PhanTypeMismatchProperty Assigning \stdClass to property but \RunkitGlobal::undeclaredTypeVar is string
```
