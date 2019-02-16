# Summary
Simple class to download and cache the public visible github repositories by username.

# Usage

    $github = new GitHubRepoCache('username');
    $repos = $repos->getRepos();

# Test
As features are added, there will be new tests to prove they work as intended. 
You can run the tests yourself using the following command.

    vendor/bin/phpunit test
