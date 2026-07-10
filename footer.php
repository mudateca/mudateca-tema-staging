</main> <!-- Fecha a tag main principal do site -->

    <footer class="muda-footer-wrapper">
      <div class="muda-footer-container">
        
        <!-- 1. Copyright (O ano atualiza sozinho) -->
        <div class="muda-footer-copyright">
          &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. Todos os direitos reservados.
        </div>

        <!-- 2. Políticas e Links -->
        <nav aria-label="Links do Rodapé">
          <?php 
          // Verifica se você criou um menu no painel do WP e o exibe
          if ( has_nav_menu( 'footer-policies' ) ) {
              wp_nav_menu( array(
                  'theme_location' => 'footer-policies',
                  'container'      => false,
                  'menu_class'     => 'muda-footer-policies',
                  'depth'          => 1,
              ) );
          } else {
              // HTML Padrão caso você ainda não tenha criado o menu no painel
              echo '<ul class="muda-footer-policies">';
              echo '<li><a href="/politica-de-privacidade">Política de Privacidade</a></li>';
              echo '<li><a href="/termos-de-servico">Termos de Serviço</a></li>';
              echo '<li><a href="/trocas-e-devolucoes">Trocas e Devoluções</a></li>';
              echo '</ul>';
          }
          ?>
        </nav>

        <!-- 3. Redes Sociais -->
        <div class="muda-footer-socials">
          <a href="https://instagram.com/seu-perfil" target="_blank" aria-label="Instagram">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
              <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
              <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
            </svg>
          </a>
          <a href="https://tiktok.com/@seu-perfil" target="_blank" aria-label="TikTok">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"></path>
            </svg>
          </a>
          <a href="https://linkedin.com/in/seu-perfil" target="_blank" aria-label="LinkedIn">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path>
              <rect x="2" y="9" width="4" height="12"></rect>
              <circle cx="4" cy="4" r="2"></circle>
            </svg>
          </a>
        </div>

      </div>
    </footer>

    <!-- Hook essencial do WordPress para plugins e scripts de rodapé funcionarem -->
    <?php wp_footer(); ?>
  </body>
</html>