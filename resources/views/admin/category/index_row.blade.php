<tr>
    <td>
        {{ $key + 1 }}
    </td>
    <td>
        {{ $prefix ?? '' }} {{ $category->name ?? '' }}
    </td>
    <td>
        @if ($category->parentCategory)
            {{ $category->parentCategory->name ?? '' }}
        @else
            <div class="text-danger" role="alert">
                {{ __('titles.root-category') }}
            </div>
        @endif
    </td>
    <td>
        {{ $category->slug ?? '' }}
    </td>
    <td>
        <a href="{{ route('categories.edit', $category->id) }}"
            class="active styling-edit" ui-toggle-class="">
            <i class="fas fa-edit text-success text-active"></i>
        </a>
        <form action="{{ route('categories.destroy', $category->id) }}"
            method="POST">
            @csrf
            @method('DELETE')
            <button id="#del" type="submit" class="delete-icon"
                onclick="ConfirmDelete('{{ __('messages.confirmDelete', ['name' => __('titles.category')]) }}')">
                <i class="fa fa-times text-danger text"></i>
            </button>
        </form>
    </td>
</tr>
