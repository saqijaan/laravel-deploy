<?php

namespace App\Services\Deploy\Helpers;

class SshKey extends BaseHelper
{
    static public function generateKeys($project, $overwrite = false)
    {
        $host = self::getHost($project);

        $key_name = "~/.ssh/project_{$project->id}";

        if(!$overwrite && $host->test("[ -f {$key_name} ]")){
            return;
        }
        
        $output = $host->runCommand("echo y | ssh-keygen -f {$key_name} -N \"\"");

        if($host->test("[ -f {$key_name} ]")){
            return $key_name;
        }
    }

    static public function getPublicKey($project)
    {
        $host = self::getHost($project);

        $key_name = $project->git_ssh_key;
        $pub_key_name = "{$project->git_ssh_key}.pub";

        if(empty($key_name) || !$host->test("[ -f {$pub_key_name} ]")){
            return null;
        }

        return $host->runCommand("cat {$pub_key_name}");
    }

    static public function removeKeys($project)
    {
        $host = self::getHost($project);

        $key_name = $project->git_ssh_key;
        $pub_key_name = "{$project->git_ssh_key}.pub";

        $host->runCommand("rm -f $key_name $pub_key_name");
    }
}
