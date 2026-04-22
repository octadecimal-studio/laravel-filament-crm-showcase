import { test, expect } from '@playwright/test';
import { loginAsAdmin } from './helpers/auth';

test.describe('Strona n8n (iframe)', () => {
  test.beforeEach(async ({ page }) => {
    await loginAsAdmin(page);
  });

  test('renderuje iframe z n8n.octadecimal.cloud', async ({ page }) => {
    await page.goto('/admin/n8n');

    await expect(page).toHaveURL(/\/admin\/n8n/);

    const iframe = page.locator('iframe').first();
    await expect(iframe).toBeVisible();
    await expect(iframe).toHaveAttribute('src', /n8n\.octadecimal\.cloud/);
  });

  test('pokazuje link "Otworz w nowej karcie"', async ({ page }) => {
    await page.goto('/admin/n8n');

    const link = page.getByRole('link', { name: /otworz w nowej karcie/i });
    await expect(link).toBeVisible();
    await expect(link).toHaveAttribute('target', '_blank');
    await expect(link).toHaveAttribute('href', /n8n\.octadecimal\.cloud/);
  });

  test('pozycja w nawigacji "Automatyzacje (n8n)" prowadzi do /admin/n8n', async ({ page }) => {
    await page.goto('/admin');
    const navLink = page.getByRole('link', { name: /automatyzacje \(n8n\)/i }).first();
    await expect(navLink).toBeVisible();
    await navLink.click();
    await expect(page).toHaveURL(/\/admin\/n8n/);
  });
});
