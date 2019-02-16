<?php
namespace CPS;

class GitHubRepoCache {
	public $username;

	public function __construct ($username, $timeout=86400) {
		$this->username = $username;
		$this->cache = new DataCache('github-repos','./data/',$timeout);
	}

	public function getReposFromSource () {

		$url = "https://api.github.com/users/{$this->username}/repos";
		$options = [
			CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0',
			CURLOPT_RETURNTRANSFER => true,
		];

		$ch = curl_init( $url );
		curl_setopt_array( $ch, $options );
		$result = curl_exec( $ch );

		$repos = [];

		$data = json_decode($result,true);
		foreach ($data as $r) {
			if ($r['archived'] != false) continue;
			$repos[$r['name']] = [
				'name' => $r['name'],
				'description' => $r['description'],
				'url' => $r['html_url'],
				'readme' => $this->getReadme($r['name']),
			];
		}
		$this->cache->write(json_encode($repos));
		return $repos;
	}

	public function getReadme($repo) {
		$url = "https://raw.githubusercontent.com/{$this->username}/{$repo}/master/README.md";
		$options = [
			CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0',
			CURLOPT_RETURNTRANSFER => true,
		];

		$ch = curl_init( $url );
		curl_setopt_array( $ch, $options );
		return curl_exec( $ch );
	}

	public function getRepos () {
		$data = $this->getReposFromCache();
		if (!$data) {
			$data = $this->getReposFromSource();
		}
		return $data;
	}

	public function getReposFromCache() {
		return json_decode($this->cache->read(),true);
	}
}

