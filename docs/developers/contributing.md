# Contributing

Welcome to the contribution guide for Yasumi. Contributions are encouraged and welcome, and are accepted
via pull requests on [GitHub](https://github.com/azuyalabs/yasumi "GitHub"). When contributing to Yasumi,
there are a few guidelines to keep in mind.

## Which branch?

- Please submit all pull requests for new features to the 'develop' branch.
- Please submit pull requests for bug fixes and typos to the earliest branch the issue can be found in.

## Git Commits

This project uses [Conventional Commits](https://www.conventionalcommits.org/ "Conventional Commits") for commit messages. This helps to maintain a clear and readable history, and enables automated versioning and changelog generation.

### Commit Message Format

Each commit message should follow this format:

```
<type>[optional scope]: <description>

[optional body]

[optional footer(s)]
```

### Types

- **feat**: A new feature
- **fix**: A bug fix
- **docs**: Documentation only changes
- **style**: Changes that do not affect the meaning of the code (white-space, formatting, missing semi-colons, etc)
- **refactor**: A code change that neither fixes a bug nor adds a feature
- **perf**: A code change that improves performance
- **test**: Adding missing tests or correcting existing tests
- **build**: Changes that affect the build system or external dependencies
- **ci**: Changes to our CI configuration files and scripts
- **chore**: Other changes that don't modify src or test files

### Examples

```
feat: add Bulgaria provider
fix(belgium): correct calculation for Easter Monday
docs: update contributing guidelines
test(france): add missing unit tests for Bastille Day
chore(readme): fix markdown syntax of headings
```

## Guidelines

- [PSR-12 Coding Standard](https://www.php-fig.org/psr/psr-12/ "PSR-12 Coding Standard")
  Please use the following command after you have completed your work:

    ```shell
    composer format
    ```

    This will check/correct all the code for the PSR-12 Coding Standard using the
    wonderful [php-cs-fixer](https://cs.symfony.com/ "PHP-CS-Fixer").

- **Add unit tests!** - Your Pull Request won't be accepted if it does not have tests:
    1. Ensure your new Holiday Provider contains all the necessary unit tests.
    2. Next to the file `{REGIONNAME}BaseTestCase.php`, a file called `{REGIONNAME}Test.php` needs to be present. This
       file needs to include region/country level tests and requires assertion of all expected holidays.
    3. All the unit tests and the implementation Holiday Provider require to have the correct locale, timezone and
       region/country name.
    4. As almost all the tests use automatic iterations, so make sure the year for which the test is executed is a valid
       year. Some holidays only are established from a certain year and having the test year number lower than the
       minimum establishment year (amongst all holidays) can result in false errors.

- Ensure that the **current tests pass**, and if you've added something new, add the tests where relevant.

- **One pull request per feature** - If you want to contribute more than one thing, send multiple pull requests.

- **Send coherent history** - Make sure each individual commit in your pull request is meaningful. If you had to make
  multiple intermediate commits while developing,
  please [squash them](https://www.git-scm.com/book/en/v2/Git-Tools-Rewriting-History "Squash them") before submitting.

- You may also need to [rebase](https://git-scm.com/book/en/v2/Git-Branching-Rebasing "Rebase") to avoid merge
  conflicts.

- Remember that Yasumi follows [SemVer](https://semver.org/ "Semantic Versioning"). If you are changing
  the behaviour, or the public API, you may need to update the docs.
