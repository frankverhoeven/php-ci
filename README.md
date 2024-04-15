# PHP CI

Automatically detect and run CI checks, based on available packages and
configuration files.


## Installation

```shell
composer r frankverhoeven/php-ci --dev
```

## Usage

After installation, run the following command:

```shell
vendor/bin/ci
```

It will automatically detect and run all available CI checks.


### GitHub Actions

Add a configuration file similar to the following:

```yaml
# .github/workflows/test.yaml

name: Test

on: push

concurrency:
    group: test-${{ github.ref }}
    cancel-in-progress: true

jobs:
    setup:
        runs-on: ubuntu-latest
        steps:
            -   uses: actions/checkout@v4
            -   uses: shivammathur/setup-php@v2
                with:
                    php-version: 8.3
                    coverage: none
            -   uses: ramsey/composer-install@v3
            -   id: set-php-versions
                run: echo "php-versions=$(vendor/bin/ci list:php-versions)" >> $GITHUB_OUTPUT
            -   id: set-tools
                run: echo "tools=$(vendor/bin/ci list:enabled-tools)" >> $GITHUB_OUTPUT
        outputs:
            php-versions: ${{ steps.set-php-versions.outputs.php-versions }}
            tools: ${{ steps.set-tools.outputs.tools }}

    test:
        needs: setup
        runs-on: ubuntu-latest
        
        strategy:
            matrix:
                php-version: ${{ fromJson(needs.setup.outputs.php-versions) }}
                tool: ${{ fromJson(needs.setup.outputs.tools) }}
            fail-fast: false
            
        name: ${{ matrix.php-version }} - ${{ matrix.tool }}
        
        steps:
            -   uses: actions/checkout@v4
            -   uses: shivammathur/setup-php@v2
                with:
                    php-version: ${{ matrix.php-version }}
                    tools: cs2pr
            -   uses: ramsey/composer-install@v3
            -   run: echo "::add-matcher::${{ runner.tool_cache }}/php.json"
            -   run: echo "::add-matcher::${{ runner.tool_cache }}/phpunit.json"

            -   run: vendor/bin/ci ${{ matrix.tool }} --format=github
```

Push to your repo and verify results.
