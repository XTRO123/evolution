<?php

use EvolutionCMS\Facades\ManagerTheme;

/** @var EvolutionCMS\Models\SiteHtmlsnippet $item */
?>
<li>
    <div class="rTable">
        <div class="rTableRow">
            @if(!empty($item->isAlreadyEdit))
                <div class="lockCell">
                        <?php
                        $rowLock = $item->alreadyEditInfo; ?>
                    <span title="{{ str_replace(['[+lasthit_df+]', '[+element_type+]'], [$rowLock['lasthit_df'], __('global.lock_element_type_2')], __('global.lock_element_editing')) }}"
                          class="editResource" style="cursor:context-menu;">
                        <i class="{{ ManagerTheme::getStyle('icon_eye') }}"></i>
                    </span>&nbsp;
                </div>
            @endif
            <div class="mainCell elements_description">
                <span class="rTableRowTitle @if($item->disabled) disabledPlugin @endif">
                    <a class="man_el_name site_htmlsnippets" target="main" data-type="site_htmlsnippets"
                       data-id="{{ $item->id }}" data-catid="{{ $item->category }}"
                       href="{{ $item->makeUrl('actions.edit') }}">
                        <i class="{{ ManagerTheme::getStyle('icon_chunk') }}"></i>
                        @if($item->locked)
                            <i class="{{ ManagerTheme::getStyle('icon_lock') }}"></i>
                        @endif
                        {{ $item->name }}
                        <small>({{ $item->id }})</small>
                        <span class="elements_descr">
                            {{ $item->caption }}
                            {!! str_replace(['&lt;strong&gt;', '&lt;/strong&gt;'], ['<strong>', '</strong>'], e($item->description)) !!}
                        </span>
                    </a>
                </span>
            </div>
            <div class="btnCell">
                <ul class="elements_buttonbar">
                    @if(evo()->hasPermission('edit_chunk'))
                        <li>
                            <a href="{{ $item->makeUrl('actions.edit') }}" target="main"
                               title="{{ __('global.edit_resource') }}">
                                <i class="{{ ManagerTheme::getStyle('icon_edit') }}"></i>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;"
                               onclick="actionDisableElement(this)"
                               title="@if($item->disabled) {{ __('global.enable') }} @else {{ __('global.disable') }} @endif"
                               data-disabled="{{ $item->disabled }}"
                               data-enable-href="{{ $item->makeUrl('actions.enable', false, ['disabled' => 0]) }}"
                               data-enable-title="{{ __('global.enable') }}"
                               data-enable-icon="{{ ManagerTheme::getStyle('icon_enable') }}"
                               data-disable-href="{{ $item->makeUrl('actions.disable', false, ['disabled' => 1]) }}"
                               data-disable-title="{{ __('global.disable') }}"
                               data-disable-icon="{{ ManagerTheme::getStyle('icon_disable') }}"
                            >
                                <i class="@if($item->disabled) {{ ManagerTheme::getStyle('icon_enable') }} @else {{ ManagerTheme::getStyle('icon_disable') }} @endif"></i>
                            </a>
                        </li>
                    @endif
                    @if(evo()->hasPermission('new_chunk'))
                        <li>
                            <a href="{{ $item->makeUrl('actions.duplicate') }}" target="main"
                               title="{{ __('global.resource_duplicate') }}"
                               onclick="return confirm(`{{ __('global.confirm_duplicate_record') }}`)">
                                <i class="{{ ManagerTheme::getStyle('icon_clone') }}"></i>
                            </a>
                        </li>
                    @endif
                    @if(evo()->hasPermission('delete_chunk'))
                        <li>
                            <a href="{{ $item->makeUrl('actions.delete') }}" target="main"
                               title="{{ __('global.delete') }}"
                               onclick="return confirm(`{{ __('global.confirm_delete_htmlsnippet') }}`)">
                                <i class="{{ ManagerTheme::getStyle('icon_trash') }}"></i>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</li>
