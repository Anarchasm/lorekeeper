<h3>Your Inventory <a class="small inventory-collapse-toggle collapse-toggle" href="#userInventory" data-toggle="collapse">Show</a></h3>
<div class="card mb-3 collapse show" id="userInventory">
    <div class="card-body">
        <div class="text-right mb-3">
            <div class="d-inline-block">
                {!! Form::label('item_category_id', 'Filter:', ['class' => 'mr-2']) !!}
                <select class="form-control d-inline-block w-auto" id="userItemCategory">
                    <option value="all">All Categories</option>
                    <option value="selected">Selected Items</option>
                    <option disabled>&#9472;&#9472;&#9472;&#9472;&#9472;&#9472;&#9472;&#9472;&#9472;&#9472;</option>
                    <option value="0">Miscellaneous</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="d-inline-block">
                {!! Form::label('item_category_id', 'Action:', ['class' => 'ml-2 mr-2']) !!}
                <a href="#" class="btn btn-primary inventory-select-all">Select All Visible</a>
                <a href="#" class="btn btn-primary inventory-clear-selection">Clear Visible Selection</a>
            </div>
        </div>
        <div id="userItems" class="user-items">
            <table class="table table-sm">
                <thead class="thead-light">
                    <tr class="d-flex">
                        <th class="col-1"><input id="toggle-checks" type="checkbox"></th>
                        <th class="col-2">Item</th>
                        <th class="col-4">Source</th>
                        <th class="col-3">Notes</th>
                        <th class="col-2">Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inventory as $itemRow)
                        <tr id ="itemRow{{ $itemRow->id }}" class="d-flex {{ $itemRow->isTransferrable ? '' : 'accountbound' }} user-item select-item-row category-all category-{{ $itemRow->item->item_category_id ? : 0 }} {{ isset($selected) && in_array($itemRow->id, array_keys($selected)) ? 'category-selected' : '' }}">
                            <td class="col-1">{!! Form::checkbox((isset($fieldName) && $fieldName ? $fieldName : 'stack_id[]'), $itemRow->id, isset($selected) && in_array($itemRow->id, array_keys($selected)) ? true : false, ['class' => 'inventory-checkbox']) !!}</td>
                            <td class="col-2">@if(isset($itemRow->item->image_url)) <img class="small-icon" src="{{ $itemRow->item->image_url }}"> @endif {!! $itemRow->item->name !!}
                            <td class="col-4">{!! array_key_exists('data', $itemRow->data) ? ($itemRow->data['data'] ? $itemRow->data['data'] : 'N/A') : 'N/A' !!}</td>
                            <td class="col-3">{!! array_key_exists('notes', $itemRow->data) ? ($itemRow->data['notes'] ? $itemRow->data['notes'] : 'N/A') : 'N/A' !!}</td>
                            @if($itemRow->availableQuantity || in_array($itemRow->id, array_keys($selected)))
                                @if(in_array($itemRow->id, array_keys($selected)))
                                    <td class="col-2">{!! Form::selectRange('stack_quantity[]', $selected[$itemRow->id], $itemRow->getAvailableContextQuantity($selected[$itemRow->id]), 1, ['class' => 'quantity-select', 'type' => 'number', 'style' => 'min-width:40px;']) !!} /{{ $itemRow->getAvailableContextQuantity($selected[$itemRow->id]) }} @if($page == 'trade') @if($itemRow->getOthers($selected[$itemRow->id], 0)) {{ $itemRow->getOthers($selected[$itemRow->id], 0) }} @endif @else @if($itemRow->getOthers(0, $selected[$itemRow->id])) {{ $itemRow->getOthers(0, $selected[$itemRow->id]) }} @endif @endif</td>
                                @else
                                    <td class="col-2">{!! Form::selectRange('', 1, $itemRow->availableQuantity, 1, ['class' => 'quantity-select', 'type' => 'number', 'style' => 'min-width:40px;']) !!} /{{ $itemRow->availableQuantity }} @if($itemRow->getOthers()) {{ $itemRow->getOthers() }} @endif</td>
                                @endif
                            @else
                                <td class="col-2">{!! Form::selectRange('', 0, 0, 0, ['class' => 'quantity-select', 'type' => 'number', 'style' => 'min-width:40px;', 'disabled']) !!} /{{ $itemRow->availableQuantity }} @if($itemRow->getOthers()) {{ $itemRow->getOthers() }} @endif</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>