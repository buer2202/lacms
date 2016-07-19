<?php
function selectTree ($tree, $value) {
    foreach($tree as $leaf) {
        $tab = '';
        $tab = str_repeat('&nbsp;', ($leaf['level']) * 4);
        if($value == $leaf['cid']) {
            echo '<option value="' . $leaf['cid'] . '" selected>' . $tab . $leaf['name'] . '</option>';
        } else {
            echo '<option value="' . $leaf['cid'] . '">' . $tab . $leaf['name'] . '</option>';
        }

        if(isset($leaf['branch'])) {
            selectTree($leaf['branch'], $value);
        }
    }
}
?>

<select id="{{ $select['id'] }}" name="{{ $select['name'] }}" class="{{ $select['class'] }}">
    @if($showRoot)
        <option value="0">/</option>
    @endif
    {{ selectTree($tree, $select['value']) }}
</select>