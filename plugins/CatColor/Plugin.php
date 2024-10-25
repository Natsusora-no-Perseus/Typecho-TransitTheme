<?php
/**
 * Typecho 分类着色插件
 *
 * @package CatColor
 * @author natsumeai
 * @version 0.3.0
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;

class CatColor_Plugin implements Typecho_Plugin_Interface
{
    /**
     * Activate the plugin and handle any necessary database changes.
     *
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        // Get database connection and prefix
        $db = Typecho_Db::get();
        $adapter = $db->getAdapterName();
        $prefix = $db->getPrefix();

        try {
            if ($adapter === 'Pdo_Mysql') {
                $result = $db->fetchAll($db->query("SHOW COLUMNS from {$prefix}metas"));
            } elseif ($adapter === 'Pdo_SQLite') {
                // For SQLite, use PRAGMA to check for the column
                $result = $db->fetchAll($db->query("PRAGMA table_info(`{$prefix}metas`)"));
            }
        } catch (Typecho_Db_Exception $e) {
            throw new Typecho_Plugin_Exception('读取数据表列失败' . $e->getCode());
        }

        if ($adapter === 'Pdo_Mysql') {
            $result = $db->select('COUNT(*)')
                ->from($prefix . 'metas')
                ->where('column_name = category_color');
        }
        else
        {
            $result= array_filter($result, function ($column) {
                return $column['name'] === 'category_color';
            });
        }

        if (empty($result)) {
            // Create the table for category colors if it doesn't exist
            /* MySQL code, not tested
            if ($adapter === 'Pdo_Mysql') {
                // MySQL create table command
                // $db->query('ALTER TABLE `' . $db->getPrefix() . 'metas` ADD `category_color` VARCHAR(7) DEFAULT NULL');
             */
            try {
                if ($adapter === 'Pdo_Mysql') {
                    $db->query("ALTER TABLE `{$prefix}metas` ADD `category_color` VARCHAR(7)");
                } elseif ($adapter === 'Pdo_SQLite') {
                    $db->query("ALTER TABLE `{$prefix}metas` ADD `category_color` VARCHAR(7)");
                }
            } catch (Typecho_Db_Exception $e) {
                // Query error handling
                throw new Typecho_Plugin_Exception(_t('Error while checking or adding `category_color` column: ') . $e->getMessage());
            }
        }

        return _t('分类颜色标注插件启用成功');
    }

    /**
     * Deactivate the plugin.
     */
    public static function deactivate()
    {
        return _t('分类颜色标注插件已禁用');
    }

    /**
     * Configuration for the plugin.
     */
    public static function config(Typecho_Widget_Helper_Form $form)
    {
        // We can change the plugin's description here.
        $description = new Typecho_Widget_Helper_Form_Element_Text(
            'description', null, null, _t('描述'),
            _t('本插件的描述（可选）'));
        $form->addInput($description);

        // Color category processing here:
        $db = Typecho_Db::get();
        $cats = $db->fetchAll($db->select()->from('table.metas')
            ->where('type = ?', 'category'));
        $default_color = '#69E';
        $errors = []; // Holds error messages

        // Create a text field for each category
        foreach ($cats as $cat) {
            error_log('Field ' . $cat['mid'] . 'deft to' . $cat['category_color']);
            $colorField = new Typecho_Widget_Helper_Form_Element_Text(
                'category_color' . $cat['mid'], null, // Variable name
                $cat['category_color'] ?? $default_color, // Default value
                _t('分类：' . $cat['name']), // Title
                _t('请输入十六进制颜色代码') // Description
            );
            $form->addInput($colorField);
        }
    }

    public static function configHandle(array$config)
    {
        $db = Typecho_Db::get();
        $enteredColors = [];
        $default_color = '#69E';
        $errors = [];

        foreach ($config as $name => $value) {
            if (strpos($name, 'category_color') === 0) {
                // Strip out color config
                $mid = str_replace('category_color', '', $name);

                // Color code validity check
                if (self::isValidColor($value)) {
                    $enteredColors[$mid] = $value;
                } else {
                    $enteredColors[$mid] = $default_color;
                    $errors[] = $mid . '号分类颜色代码错误';
                    $config[$name] = $default_color;
                }
            }
        }

        // Store configuration to metas table
        foreach ($enteredColors as $mid => $color) {
            $db->query($db->update('table.metas')
                ->rows(array('category_color' => $color))
                ->where('mid = ?', $mid));
        }

        // Store configuration to options table
        Helper::configPlugin('CatColor', $config);

        if (!empty($errors)) {
            foreach ($errors as $error) {
                Typecho_Widget::widget('Widget_Notice')->set($error, 'error');
            }
        }

        Typecho_Widget::widget('Widget_Notice')->set(_t('插件配置更新成功', 'success'));
    }

    /**
     * No personal configuration needed.
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form)
    {
    }

    private static function isValidColor($color)
    {
        // A valid HEX color code is 3 or 6 digits, optionally starting with #
        return preg_match('/^#?([a-fA-F0-9]{3}|[a-fA-F0-9]{6})$/', $color);
    }
}
