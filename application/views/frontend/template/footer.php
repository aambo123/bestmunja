<?php if($this->session->userData('id')){ ?>
<footer class="app-footer py-3">
<div class="container">
		<a class="telegram telegram-static logged-telegram" href="https://t.me/1stbulk">
			<img src="/assets/images/telegram.png" alt="">
			<div>
				<h3>가입상담</h3>
				<p><span>Telegram id:</span> 1stbulk</p>
			</div>
		</a>
	</div>

	<div class="container">
		<div class="footer-copyright">
			<p class="font-weight-bold txt-center">© 2019 - <?php echo date('Y');?> 1stBulk. ALL RIGHTS RESERVED.</p>
		</div>
	</div>
</footer>
</div>
</main>

</div>


<?php } ?>
</body>

</html>
