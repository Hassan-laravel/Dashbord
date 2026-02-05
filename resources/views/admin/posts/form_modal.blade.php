<div class="modal fade" id="articleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                {{-- Modal title: will be dynamically changed based on the state (Add/Edit) later --}}
                <h5 class="modal-title">{{ __('dashboard.articles.add_article') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="article-form">

                    {{-- Language Tabs --}}
                    <ul class="nav nav-tabs mb-3" id="langTabs" role="tablist">
                        @foreach(config('language.supported') as $key => $lang)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                        id="{{ $key }}-tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#lang-{{ $key }}"
                                        type="button">
                                    {{ $lang['name'] }}
                                </button>
                            </li>
                        @endforeach
                    </ul>

                    {{-- Tab Content --}}
                    <div class="tab-content mb-3" id="langTabsContent">
                        @foreach(config('language.supported') as $key => $lang)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="lang-{{ $key }}">

                                {{-- Title Field (Translated) --}}
                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ __('dashboard.articles.article_title') }} ({{ $lang['name'] }})
                                    </label>
                                    <input type="text" class="form-control" name="{{ $key }}[title]"
                                           placeholder="{{ __('dashboard.articles.enter_title_placeholder', ['lang' => $lang['name']]) }}">
                                </div>

                                {{-- Content Field (Translated) --}}
                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ __('dashboard.articles.content') }} ({{ $lang['name'] }})
                                    </label>
                                    <textarea class="form-control" rows="4" name="{{ $key }}[content]"></textarea>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <hr>

                    {{-- General Fields --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('dashboard.articles.category') }}</label>
                            <select class="form-select" name="category_id">
                                <option selected>{{ __('dashboard.articles.select_category') }}</option>
                                <option value="1">Technology</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('dashboard.articles.image') }}</label>
                            <input type="file" class="form-control" name="image">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('dashboard.general.close') }}</button>
                <button type="button" class="btn btn-primary">{{ __('dashboard.general.save') }}</button>
            </div>
        </div>
    </div>
</div>
