<?php if($this->session->userData('id')){ ?>
<footer class="app-footer py-3">
	<div class="container">
		
	</div>

	<div class="container">
		<div class="footer-copyright">
			<p class="font-weight-bold txt-center">© 2019 - <?php echo date('Y');?> <?php echo $this->config->item("site_name")?>. ALL RIGHTS RESERVED.</p>
		</div>
	</div>
</footer>
</div>
</main>

</div>


<?php } ?>
</body>

</html>
