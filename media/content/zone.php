<div id="form-center">
    <table style="width: 100%;" border="0" cellspacing="0" cellpadding="1">
        <tbody>

            <tr>
                <td width="100px">Область:</td>
                <td>
                    <div id="box_regionid">
                        <?php
                            echo get_zone_block();
                        ?>
                    </div>
                </td>
            </tr>

            <tr>
                <td> </td>
                <td>
                    <div id="box_fbe55253"><span id="fbe55253"><br />Выберите валюту для отображения цен на сайте</span></div>
                </td>
            </tr>
            <tr>
                <td>Валюта:</td>
                <td>
                    <div id="box_f150fbeb">

                    <script type="text/javascript">
                        $(document).ready(function(){

                            $("#currencies_id").change(

                            function (){

                                var log_cur = $("#log_cur");
                                log_cur.fadeIn();
                                id = $("#currencies_id option:selected").val();
                                $.ajax({
                                    type: "POST", url: "index.php?page=seller_cur_page&currencies_id="+id, data: "",
                                    complete: function(data)
                                    {
                                       // log_cur.html(data.responseText);
                                        log_cur.html('<font color="green"><b>Сохранено</b></font>');
                                        log_cur.fadeOut(2000);
                                    }
                                });
                            }
                            );

                        });

                    </script>
                    <?php

                        if (isset($osPrice) && is_object($osPrice)) 
                        {

                            $currencies_string = '';
                            $count_cur='';
                            reset($osPrice->currencies);

                            echo '<select id="currencies_id">';

                            foreach ($osPrice->currencies as $code => $value)
                            {
                                if ( $code == $_SESSION['currency'] )
                                {
                                    echo '<option selected value="'.$code.'">'.$code.'</option>';
                                }
                                else
                                {
                                    echo '<option value="'.$code.'">'.$code.'</option>';
                                }
                            }

                            echo '</select>';
                            
                           echo '<span style="padding-left: 5px;" id="log_cur"></span>';

                        }

                    ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>