import { test, expect } from '@playwright/test';
import { loginAsAdmin } from './helpers/auth';

test.describe('Sidebar - zewnetrzne linki', () => {
  test.beforeEach(async ({ page }) => {
    await loginAsAdmin(page);
  });

  test('sekcja "Linki zewnetrzne" z 3 linkami otwierajacymi sie w nowej karcie', async ({ page }) => {
    await page.goto('/admin');
    await page.waitForLoadState('networkidle');

    // Screenshot dla wizualnej weryfikacji
    await page.screenshot({ path: 'test-results/sidebar-external-links.png', fullPage: true });

    // Wszystkie 3 linki z target=_blank
    for (const [name, host] of [
      ['Chat', 'chat.octadecimal.cloud'],
      ['CRM', 'crm.octadecimal.cloud'],
      ['n8n', 'n8n.octadecimal.cloud'],
    ]) {
      const link = page.getByRole('link', { name: new RegExp(`${name} \\(${host}\\)`, 'i') }).first();
      await expect(link).toBeVisible();
      await expect(link).toHaveAttribute('target', '_blank');
      await expect(link).toHaveAttribute('href', new RegExp(host));
    }
  });
});
