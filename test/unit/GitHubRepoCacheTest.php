<?php
namespace App\Test;
use CPS\GitHubRepoCache;
use PHPUnit\Framework\TestCase;

class GitHubRepoCacheTest extends TestCase {

	public function testICanGetRepos() {
		$repos = new GitHubRepoCache('christopher-paul-shaw');
		$my_repos = $repos->getRepos();
		$this->assertTrue(count($my_repos) > 0);
	}

}