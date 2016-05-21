<?php

/**
 * I needed something that sends emails on dev/build. Later it became this release notificator.
 *
 * @author peter.thaleikis@catalyst.net.nz
 */

class ReleaseNotification extends DataObject
{
    /**
     * @var array
     */
    private static $db = array(
        'Changelog' => 'Text',
    );

    /**
     * We are abusing requireDefaultRecords to run this on dev/build.
     */
    public function requireDefaultRecords()
    {
        parent::requireDefaultRecords();

        // get the config based on the URL (URL is key)
        $config = $this->prepConfig($this->config()->get('environments'), Director::absoluteURL('/'));

        // only run if everything is fine
        if (is_array($config) && file_exists('../' . $config['filename'])) {
            // get the information in the database for the last release notification
            $record = (self::get()->count() == 0) ? new self() : self::get()->first();

            // load the changelog
            $changelog = file_get_contents('../' . $config['filename']);

            // check if the CHANGELOG.md file has been changed since the last run
            if ($changelog != '' && md5($changelog) != md5($record->Changelog)) {
                // email the changelog out
                foreach ($config['recipients'] as $recipient) {
                    Email::create(
                        $config['from'],
                        $recipient,
                        $config['subject'],

                        // remove the old part and add more useful information to the content
                        sprintf(
                            "%s (%s)\n\n%s",
                            $config['environment_name'],
                            $config['url'],
                            $changelog
                        )
                    )->sendPlain();

                    DB::alteration_message($recipient . ' notified', 'created');
                }

                // save the new changelog to ensure we aren't re-running this in the next step
                $record->Changelog = $changelog;
            }

            // say welcome :)
            if (!$record->ID) {
                DB::alteration_message('Install of FriendsOfSilverStripe/release-notifications');
            }

            $record->write();
        }
    }

    /**
     * sorts the config a bit different and returns it.
     *
     * @param array  $environments
     * @param string $url
     *
     * @return array (either configuration or empty)
     */
    public function prepConfig($environments, $url)
    {
        $environmentsByURL = array();

        foreach ($environments as $environment) {
            if (is_array($environment) && array_key_exists('url', $environment)) {
                $environmentsByURL[$environment['url']] = $environment;
            }
        }

        return array_key_exists($url, $environmentsByURL) ? $environmentsByURL[$url] : [];
    }
}
