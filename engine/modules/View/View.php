<?php

namespace Excore\Core\Modules\View;

use Excore\Core\Config\Env;
use Excore\Core\Config\Path;
use Excore\Core\Modules\Http\Request;
use Excore\Core\Modules\View\Exceptions\ViewException;

class View
{
    protected string $layout = 'app';
    protected string $title = 'Excore - ';

    public function __construct(private Request $request)
    {
    }

    public static function init(Request $request)
    {
        return new static($request);
    }

    public function setLayout(string $layout)
    {
        $this->layout = $layout;
    }

    public function title(string $title)
    {
        $this->title .= $title;
    }

    public function render(string $template, array $data = [])
    {
        $templateFile = $this->getTemplateFilePath($template);
        $layoutFile = $this->getLayoutFilePath();

        if (file_exists($templateFile) && file_exists($layoutFile)) {
            $content = $this->renderTemplate($templateFile, $data);
            $layoutContent = $this->loadLayoutContent($layoutFile);
            $layoutContent = $this->contentPlaceholder($layoutContent, $content);
            $layoutContent = $this->parsing($layoutContent);


            ob_start();
            eval(' ?>' . $layoutContent . '<?php ');
            ob_end_flush();
        } else {
            throw new ViewException("Template or layout file not found.");
        }
    }

    private function getTemplateFilePath(string $template): string
    {
        return Path::views() . $template . '.exc.php';
    }

    private function getLayoutFilePath(): string
    {
        return Path::layouts() . $this->layout . '.exc.php';
    }

    private function renderTemplate(string $templateFile, array $data): string
    {
        extract($data);
        ob_start();
        include $templateFile;
        return ob_get_clean();
    }

    private function loadLayoutContent(string $layoutFile): string
    {
        return file_get_contents($layoutFile);
    }

    private function contentPlaceholder(string $layoutContent, string $content): string
    {
        return str_replace('<ex-content>', $content, $layoutContent);
    }

    private function replacePlaceholder(array $placeholders, string $template): string
    {
        foreach ($placeholders as $placeholder => $replacement) {
            $template = str_replace($placeholder, $replacement, $template);
        }
        return $template;
    }

    private function parsing(string $template)
    {
        return $this->replacePlaceholder($this->getPlaceholders(), $template);
    }


    private function getPlaceholders()
    {
        return [
            "<ex-header>" => "<?php require(\Excore\Core\Config\Path::components() . 'header.exc.php'); ?>",
            "<ex-sidebar>" => "<?php require(\Excore\Core\Config\Path::components() . 'sidebar.exc.php'); ?>",
            "<ex-assets>" => "<?php echo \Excore\Core\Config\Assets::css();?>",
            "<ex-scripts>" => "<?php echo \Excore\Core\Config\Assets::js();?>",
            "<ex-title>" => '<?php echo $this->title;?>',
        ];
    }
}
