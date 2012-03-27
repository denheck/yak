<?php
$downloads = json_decode(
   file_get_contents(
       'https://api.github.com/repos/jimbojsb/yak/downloads'
   ),
   true
);

$versions = array();
foreach ($downloads as $download) {
   preg_match("/\d\.\d\.?\d?/", $download["name"], $matches);
   if ($matches[0]) {
       $versions[$matches[0]] = $download["html_url"];
   }
}
$versionNumbers = array_keys($versions);
sort($versionNumbers);
$maxAvailableVersion = array_pop($versionNumbers);
$output->writeln("<info>Upgrading from $currentVersion to $maxAvailableVersion</info>");
copy($versions[$maxAvailableVersion], dirname($_SERVER['SCRIPT_NAME']) . DIRECTORY_SEPARATOR . 'yak');
chmod(dirname($_SERVER['SCRIPT_NAME']) . DIRECTORY_SEPARATOR . 'yak', 0755);