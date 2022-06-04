{extends file="parent:backend/_base/discount_per_square_module.tpl"}

{block name="content/main"}
    <p class="dps-info">In order to set the discount percentage over given amount of unit go to <b>Plugin manager -> DiscountPerSquare</b> and fill the
        values for all shops.</p>
   <div class="container">
           <div style="max-width: 550px; display: flex; justify-content: space-evenly; margin-top: 2%;margin-left: 1%; margin-bottom: 10px; ">
               <button onclick="generateClick()" style=" padding: 1rem 1rem; background:#0b6dbe; border:none; color:#fff; border-radius:
        3px; transition: all 0.6s; letter-spacing: 0.5px; font-size: 14px; width: 37%;" class="generate" id="generate">Generate
                   discount
                   prices</button>
               <button onclick="deleteClick()"
                       style="padding: 1rem 1.3rem;background:#0b6dbe; border:none; color:#fff; border-radius: 3px; transition: all 0.6s; letter-spacing: 0.5px; font-size: 14px; width: 37%;"
                       class=" delete" id="delete">Delete
                   discount prices</button>
           </div>


       <div style="max-width: 29%; text-align:center;margin-top: 10%; margin-left: 4%; display:none;" class="alert" id="generated">
           <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
           <strong>Success!</strong>You have successfully generated a new discount price!
       </div>

       <div style="max-width:29%;margin-top: 10%; margin-left: 4%; text-align:center; display:none;" class="alert" id="deleted">
           <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
           <strong>Success!</strong>You have successfully deleted all price discounts!
       </div>
   </div>
{literal}
    <script type="text/javascript">

        function generateClick() {
            $.ajax({
                type: "POST",
                url: "DiscountPerSquareModulePlainHtml/generate",
                dataType: "json",
                success: function (response) {
                    document.getElementById('generated').style.display = 'block'
                    document.getElementById('generate').disabled = true

                    setTimeout(function(){
                        document.getElementById('generated').style.display = 'none'
                    },3000);
                },
                error: function(er){
                    alert('Not done')
                }
            });

        }

        function deleteClick() {
            $.ajax({
                type: "POST",
                url: "DiscountPerSquareModulePlainHtml/delete",
                dataType: "json",
                success: function (response) {
                    document.getElementById('deleted').style.display = 'block'
                    document.getElementById('delete').disabled = true

                    setTimeout(function(){
                        document.getElementById('deleted').style.display = 'none'
                    },3000);
                },
                error: function(er){
                    alert('Not done')
                }
            });

        }
    </script>
{/literal}
{/block}