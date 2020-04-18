
{{ partial("layouts/templates/header") }}

<div class="center-block">

	{{ flash.output() }}

	{{ content() }}  

</div>

{{ partial("layouts/templates/footer") }}
