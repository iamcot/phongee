<? if(count($aDeal) > 0):?>
    <? $i= $page*$this->config->item("num_admindealuserlist") + 1;  foreach($aDeal as $deal):?>
        <tr class="<?=(($i%2==0))?'odd':''?>">
            <td><?=$i?></td>
            <td><?=$deal->id?></td>
            <td><?=$deal->dadeal_id?></td>
            <td><?=$deal->daname?></td>
            <td><?=date("H:i d/m/Y",strtotime($deal->dacreate))?></td>
            <td><?=$deal->daemail?></td>
            <td><?=$deal->datel?></td>
            <td><?=$deal->daamount?></td>
            <td><?=$deal->daaddr?></td>
            <td><?=$deal->dacomment?></td>

            <td>
                <select class="dealuserstatusselect" name="dastatus">
                    <? foreach($this->config->item('dealuserstatus') as $key=>$status):?>
                        <option value="<?=$deal->id?>-<?=$key?>" <?=(($key == $deal->dastatus)?'selected="selected"':'')?>><?=$status?></option>
                    <? endforeach;?>
                </select>
                </td>
            <td><a href="javascript:viewlogdeal(<?=$deal->id?>)">Log</a></td>
        </tr>

    <? $i++; endforeach;?>
    <tr><td colspan="10">
            <div class="pagination">
                <a href="#" class="first" data-action="first">&laquo;</a>
                <a href="#" class="previous" data-action="previous">&lsaquo;</a>
                <input type="text" readonly="readonly" data-max-page="<?=$sumpage?>" />
                <a href="#" class="next" data-action="next">&rsaquo;</a>
                <a href="#" class="last" data-action="last">&raquo;</a>
            </div>

    </td></tr>
<? endif;?>
<script>
    var crr = $("input[name=dealuser_currentpage]").val();
    $('.pagination').jqPagination({
        paged: function(page) {
            loaddealuserlist(page);
        },
        current_page: <?=($page+1)?>
    });
    $(function(){
        var previous;

        $(".dealuserstatusselect").focus(function () {
            // Store the current value on focus and on change
            previous = this.value;
        }).change(function() {
                // Do something with the previous value after the change
                console.log(previous+"=>"+this.value);
                addsavegif("#dlstatus");
                $.ajax({
                    type: "post",
                    url: "<?=base_url()?>admin/changedealstatus/",
                    data: "newstatus="+$(this).val()+"&oldstatus="+previous,
                    success: function(msg){
                        if(msg==0) alert("Cập nhật thất bại");
                        loaddealuserlist($("input[name=dealuser_currentpage]").val());
                        removeloadgif("#dlstatus");
                    }
                });
                // Make sure the previous value is updated
                previous = this.value;
            });
    });
    </script>