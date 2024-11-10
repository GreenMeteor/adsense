<?php

namespace humhub\modules\adsense\models;

use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\helpers\ArrayHelper;

/**
 * ConfigureForm model for handling AdSense configuration and ads.txt content.
 */
class ConfigureForm extends Model
{
    public $client;
    public $slot;
    public $sort;
    public $adsTxtContent;

    private $adsTxtFilePath;

    /**
     * Initializes the model and sets the ads.txt file path.
     */
    public function init()
    {
        parent::init();
        $this->adsTxtFilePath = Yii::getAlias('@webroot/ads.txt');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client', 'slot', 'sort'], 'safe'],
            [['client'], 'string', 'max' => 255],
            [['slot'], 'string', 'max' => 255],
            [['adsTxtContent'], 'string'],
            [['adsTxtContent'], 'validateAdsTxtFormat'],
            [['adsTxtContent'], 'validateAdsTxtMaxLength'],
            [['adsTxtContent'], 'validateSingleLine'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'client' => Yii::t('AdsenseModule.base', 'Client'),
            'slot' => Yii::t('AdsenseModule.base', 'Slot'),
            'sort' => Yii::t('AdsenseModule.base', 'Sort Order'),
            'adsTxtContent' => Yii::t('AdsenseModule.base', 'ads.txt Content'),
        ];
    }

    /**
     * Validates the ads.txt content line by line.
     *
     * @return bool Whether the content is valid.
     */
    public function validateAdsTxtContent()
    {
        $lines = explode("\n", trim($this->adsTxtContent));

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) {
                continue;
            }

            // Pass the trimmed line for format validation
            if (!$this->validateAdsTxtFormat($line)) {
                return false;
            }
        }

        return !$this->hasErrors();
    }

    /**
     * Validates the format of a single ads.txt line.
     *
     * @param string $line The ads.txt line to validate.
     * @return bool Whether the line is valid.
     */
    public function validateAdsTxtFormat($line)
    {
        $line = trim($line);

        if ($line) {
            // Define the regex patterns
            $patterns = ArrayHelper::merge(
                [
                    'domain' => '/^google\.com$/',
                    'publisher' => '/^pub-\d{16}$/',
                    'account_type' => '/^(DIRECT|RESELLER)$/',
                    'certification_id' => '/^[a-f0-9]{16}$/',
                ],
                []);

            $parts = array_map('trim', explode(',', $line));

            if (count($parts) !== 4) {
                $this->addError('adsTxtContent', Yii::t('AdsenseModule.base', 'Each line must have exactly 4 parts: <domain>, <publisher_id>, <account_type>, <certification_id>.'));
                return false;
            }

            $domain = $parts[0];
            $publisher = $parts[1];
            $accountType = $parts[2];
            $certificationId = $parts[3];

            if (!preg_match($patterns['domain'], $domain)) {
                $this->addError('adsTxtContent', Yii::t('AdsenseModule.base', 'The domain must always be google.com.'));
                return false;
            }

            if (!preg_match($patterns['publisher'], $publisher)) {
                $this->addError('adsTxtContent', Yii::t('AdsenseModule.base', 'The publisher ID must start with "pub-" followed by exactly 16 digits.'));
                return false;
            }

            if (!preg_match($patterns['account_type'], $accountType)) {
                $this->addError('adsTxtContent', Yii::t('AdsenseModule.base', 'The account type must be either "DIRECT" or "RESELLER".'));
                return false;
            }

            if (!preg_match($patterns['certification_id'], $certificationId)) {
                $this->addError('adsTxtContent', Yii::t('AdsenseModule.base', 'The certification ID must be a 16-character hexadecimal string.'));
                return false;
            }
        }

        return true;
    }

    /**
     * Validates the length of the ads.txt content.
     *
     * @param string $attribute The attribute being validated.
     * @param array $params Additional parameters for validation.
     */
    public function validateAdsTxtMaxLength($attribute, $params)
    {
        $maxLength = 56;

        $line = trim($this->$attribute);
        if (strlen($line) > $maxLength) {
            $this->addError($attribute, Yii::t('AdsenseModule.base', 'The ads.txt content must not exceed 56 characters.'));
            return;
        }
    }

    /**
     * Validates that the ads.txt content is a single line.
     *
     * @param string $attribute The attribute being validated.
     * @param array $params Additional parameters for validation.
     */
    public function validateSingleLine($attribute, $params)
    {
        $lineCount = count(explode(PHP_EOL, $this->$attribute));
        if ($lineCount > 1) {
            $this->addError($attribute, Yii::t('AdsenseModule.base', 'The ads.txt content must be a single line.'));
            return;
        }
    }

    /**
     * Loads settings from the module and the ads.txt file content.
     *
     * @return bool Whether the settings were successfully loaded.
     */
    public function loadSettings()
    {
        $module = Yii::$app->getModule('adsense');

        $this->client = $module->settings->get('client');
        $this->slot = $module->settings->get('slot');
        $this->sort = $module->settings->get('sort');

        if (file_exists($this->adsTxtFilePath)) {
            $this->adsTxtContent = file_get_contents($this->adsTxtFilePath);
        } else {
            $this->adsTxtContent = '';
        }

        if ($this->adsTxtContent && !$this->validateAdsTxtContent()) {
            $this->adsTxtContent = '';
        }

        return true;
    }

    /**
     * Saves the settings and the ads.txt content.
     *
     * @return bool Whether the settings and content were successfully saved.
     */
    public function save()
    {
        $module = Yii::$app->getModule('adsense');

        $module->settings->set('client', $this->client);
        $module->settings->set('slot', $this->slot);
        $module->settings->set('sort', $this->sort);

        if ($this->adsTxtContent !== null && $this->validateAdsTxtContent()) {
            file_put_contents($this->adsTxtFilePath, $this->adsTxtContent);
        } else {
            return false;
        }

        return true;
    }

    /**
     * Checks if the ads.txt file exists.
     *
     * @return bool Whether the ads.txt file exists.
     */
    public function adsTxtExist()
    {
        return file_exists($this->adsTxtFilePath);
    }

    /**
     * Creates a new ads.txt file with the provided content.
     *
     * @param string $content The content to write into the ads.txt file.
     */
    public function createAdsTxt($content = "")
    {
        $dir = dirname($this->adsTxtFilePath);
        if (!is_dir($dir)) {
            FileHelper::createDirectory($dir, 0775, true);
        }

        if (!file_exists($this->adsTxtFilePath)) {
            file_put_contents($this->adsTxtFilePath, $content);
        }
    }

    /**
     * Appends new content to the existing ads.txt file.
     *
     * @param string $newContent The content to append to the ads.txt file.
     */
    public function appendToAdsTxt($newContent)
    {
        if ($this->adsExist()) {
            file_put_contents($this->adsTxtFilePath, PHP_EOL . $newContent, FILE_APPEND);
        }
    }

    /**
     * Overwrites the existing ads.txt file with new content.
     *
     * @param string $newContent The new content to write into the ads.txt file.
     */
    public function overwriteAdsTxt($newContent)
    {
        if ($this->adsExist()) {
            file_put_contents($this->adsTxtFilePath, $newContent);
        }
    }
}
