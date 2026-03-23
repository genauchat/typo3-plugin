<?php

declare(strict_types=1);

namespace Genauchat\Typo3Plugin\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Registry;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class SettingsController extends ActionController
{
    private ModuleTemplateFactory $moduleTemplateFactory;

    public function injectModuleTemplateFactory(ModuleTemplateFactory $moduleTemplateFactory): void
    {
        $this->moduleTemplateFactory = $moduleTemplateFactory;
    }

    public function indexAction(): ResponseInterface
    {
        GeneralUtility::makeInstance(PageRenderer::class)->addCssInlineBlock(
            'genauchat',
            '.gc-wrap{max-width:720px;margin:2rem auto;padding:0 1rem}
            .gc-header{background:linear-gradient(135deg,#6d28d9 0%,#4f46e5 100%);border-radius:16px;padding:2rem;color:#fff;display:flex;align-items:center;gap:1.25rem;margin-bottom:1.5rem;box-shadow:0 4px 24px rgba(109,40,217,.18)}
            .gc-icon{background:rgba(255,255,255,.15);border-radius:12px;width:56px;height:56px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
            .gc-icon svg{width:30px;height:30px;stroke:#fff}
            .gc-header h1{font-size:1.6rem;font-weight:700;margin:0 0 .2rem;color:#fff;border:none}
            .gc-header p{margin:0;opacity:.85;font-size:.95rem}
            .gc-badge{margin-left:auto;padding:.45rem 1rem;border-radius:999px;font-size:.8rem;font-weight:600;display:flex;align-items:center;gap:.4rem;white-space:nowrap}
            .gc-badge--active{background:rgba(255,255,255,.2);color:#fff}
            .gc-badge--inactive{background:rgba(0,0,0,.2);color:rgba(255,255,255,.75)}
            .gc-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0}
            .gc-dot--active{background:#4ade80}
            .gc-dot--inactive{background:rgba(255,255,255,.4)}
            .gc-alert{background:#f0fdf4;border:1px solid #86efac;color:#166534;border-radius:10px;padding:.85rem 1.1rem;margin-bottom:1.5rem;display:flex;align-items:center;gap:.6rem;font-size:.9rem}
            .gc-card{background:#fff;border:1px solid #e5e7eb;border-radius:14px;overflow:hidden;box-shadow:0 1px 6px rgba(0,0,0,.06)}
            .gc-card-body{padding:1.75rem}
            .gc-label{display:block;font-weight:600;font-size:.88rem;color:#374151;margin-bottom:.5rem;text-transform:uppercase;letter-spacing:.04em}
            .gc-textarea{width:100%;border:1.5px solid #e5e7eb;border-radius:10px;padding:.85rem 1rem;font-family:monospace;font-size:.82rem;color:#1f2937;background:#f9fafb;resize:vertical;min-height:100px;box-sizing:border-box;transition:border-color .15s}
            .gc-textarea:focus{outline:none;border-color:#6d28d9;background:#fff;box-shadow:0 0 0 3px rgba(109,40,217,.08)}
            .gc-hint{font-size:.8rem;color:#6b7280;margin-top:.5rem}
            .gc-hint a,.gc-step a{color:#6d28d9;text-decoration:none}
            .gc-hint a:hover{text-decoration:underline}
            .gc-footer{padding:1.25rem 1.75rem;background:#f9fafb;border-top:1px solid #f3f4f6}
            .gc-btn{background:linear-gradient(135deg,#6d28d9 0%,#4f46e5 100%);color:#fff;border:none;border-radius:8px;padding:.6rem 1.5rem;font-size:.9rem;font-weight:600;cursor:pointer;transition:opacity .15s,transform .1s}
            .gc-btn:hover{opacity:.9;transform:translateY(-1px)}
            .gc-steps{display:grid;grid-template-columns:1fr 1fr;gap:.75rem;margin-top:1.5rem}
            .gc-step{background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:1rem;display:flex;gap:.75rem;align-items:flex-start}
            .gc-step-num{background:#ede9fe;color:#6d28d9;border-radius:6px;width:24px;height:24px;display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:700;flex-shrink:0}
            .gc-step p{margin:0;font-size:.82rem;color:#4b5563;line-height:1.4}
            .gc-toggle{display:flex;align-items:center;gap:.75rem;padding:1.1rem 1.75rem;border-bottom:1px solid #f3f4f6;cursor:pointer;user-select:none}
            .gc-toggle input[type=checkbox]{width:0;height:0;opacity:0;position:absolute}
            .gc-switch{width:44px;height:24px;background:#d1d5db;border-radius:999px;position:relative;transition:background .2s;flex-shrink:0}
            .gc-switch::after{content:"";position:absolute;top:3px;left:3px;width:18px;height:18px;background:#fff;border-radius:50%;transition:transform .2s;box-shadow:0 1px 3px rgba(0,0,0,.2)}
            input:checked+.gc-switch{background:#6d28d9}
            input:checked+.gc-switch::after{transform:translateX(20px)}
            .gc-toggle-label{font-weight:600;font-size:.9rem;color:#374151}
            .gc-toggle-desc{font-size:.8rem;color:#9ca3af;margin-top:.1rem}'
        );

        $registry = GeneralUtility::makeInstance(Registry::class);
        $script  = $registry->get('genauchat', 'widget_script', '');
        $enabled = (bool)$registry->get('genauchat', 'enabled', true);
        $saved   = $this->request->hasArgument('saved');

        $moduleTemplate = $this->moduleTemplateFactory->create($this->request);
        $moduleTemplate->assignMultiple([
            'script'   => $script,
            'enabled'  => $enabled,
            'saved'    => $saved,
            'isActive' => $enabled && $this->isValidScript($script),
        ]);
        return $moduleTemplate->renderResponse('Settings/Index');
    }

    public function saveAction(): ResponseInterface
    {
        $script = $this->request->hasArgument('script')
            ? (string)$this->request->getArgument('script')
            : '';

        $enabled = $this->request->hasArgument('enabled') ? 1 : 0;

        $registry = GeneralUtility::makeInstance(Registry::class);
        $registry->set('genauchat', 'widget_script', $script);
        $registry->set('genauchat', 'enabled', $enabled);

        return $this->redirect('index', null, null, ['saved' => 1]);
    }

    private function isValidScript(string $script): bool
    {
        return str_contains($script, 'genau.chat') && str_contains($script, '<script');
    }
}
