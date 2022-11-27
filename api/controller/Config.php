<?php
/**
 * Handle config value in /config.php
 */
class Config {

    private static $_file_path = __DIR__ . '/../../config.php';

    /**
     * Update defined value
     * @param string constant name
     * @param string constant value
     * @return string updated data
     */
    private static function update(string $constant, string $value, string $data): string {
        $appendValue = "define('$constant', '$value')";
        /**
         * Regex to search for a constant name
         * search for define('SOME_NAME', 'SOME VALUE');
         */
        return preg_replace("/define\((\s+)?\'$constant\'(\s+)?,(\s+)?\'(?'target'.+)?\'(\s+)?\)/", $appendValue, $data);
    }

    /**
     * Configure config.php value
     * @return void
     */
    public static function configure(): void {
        /**
         * this method should only work when installing app
         */
        if (APP_INSTALLED == true) {
            send_response(false, 400, ['any action in this route is not allowed']);
        }

        $fileData = file_get_contents(self::$_file_path);

        handle_content_type_json();
        $data = (array) get_json_data();

        if (count($data) === 0) {
            send_response(false, 400, ['no data found, please append data to update']);
        }

        /**
         * Don't allow app installed value
         */
        unset($data['APP_INSTALLED']);

        foreach ($data as $key => $val) {
            $fileData = self::update($key, $val, $fileData);
        }

        # Save updated data
        if (!file_put_contents(self::$_file_path, $fileData)) {
            send_response(false, 500, ['something went wrong, please try again later!']);
        }

        send_response(true, 202, ['data saved successfully']);
    }
}
