<?php
// ==================================================
// SEÇÃO DE NEWSLETTER
// ==================================================
$section_id = uniqid('news_');
?>

<div class="muda-news-section" id="<?php echo esc_attr($section_id); ?>">
  <div class="muda-news-container">
    <div class="muda-news-box">
      
      <div class="muda-news-content">
        <h2>Inscreva-se na nossa newsletter</h2>
        <p>Receba ofertas exclusivas, novidades e muito mais direto no seu e-mail.</p>
      </div>

      <div class="muda-news-form-wrapper">
        <form action="#" method="POST" class="muda-newsletter-form">
          <div class="muda-input-group">
            <input type="email" 
                   name="email_newsletter" 
                   class="muda-news-input" 
                   placeholder="Seu melhor e-mail" 
                   required>
            <button type="submit" class="muda-news-btn">Inscrever</button>
          </div>
          
          <div class="muda-news-message" style="display: none;"></div>
        </form>
      </div>

    </div>
  </div>
</div>