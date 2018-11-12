<div class="accordion-stn">
    <div class="panel-group" data-collapse-color="nk-theme" id="{{ $id }}" role="tablist" aria-multiselectable="true">
        @forelse($categories as $category)
            <div class="panel panel-collapse notika-accrodion-cus">
                <div class="panel-heading" role="tab">
                    <span class="panel-title">
                        <a data-toggle="collapse" data-parent="#{{ $id }}" href="#category-{{ $category->id }}"
                           class="{{ $loop->index === 0 ? '' : 'collapsed' }}"
                           aria-expanded="{{ $loop->index === 0 ? 'true' : 'false' }}">
                            <div class="row">
                                <div class="col-xs-8" style="color:{{ $category->color }};">
                                    <i class="fa fa-{{ $category->format_type->icon }} {{ $category->format_type->color }}"></i>
                                    <i class="fa fa-{{ $category->icon }}"></i>
                                    {{ text_format($category->name, 50) }}
                                </div>
                                <div class="col-xs-4 text-right">
                                    <a href="{{ locale_route('categories.edit', [$category]) }}" class="text-warning" title="@lang('general.update')"><i class="fa fa-pencil"></i></a>&nbsp;
                                    @if($category->can_be_deleted)
                                        <a href="javascript: void(0);" class="text-danger" data-toggle="modal" data-target="#delete-category-{{ $category->id }}" title="@lang('general.delete')"><i class="fa fa-trash-o"></i></a>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </span>
                </div>
                <div id="category-{{ $category->id }}" class="overflow collapse {{ $loop->index === 0 ? 'in' : '' }}" role="tabpanel">
                    <div class="panel-body">
                        <div class="col-xs-12 mg-b-15">
                            <p class="multi-line-text">{{ $category->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center">
                <div class="alert alert-info text-center" role="alert">
                    @lang('general.no_data')
                </div>
            </div>
        @endforelse
    </div>
</div>