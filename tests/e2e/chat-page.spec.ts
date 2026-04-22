import { test, expect } from '@playwright/test';
import { loginAsAdmin } from './helpers/auth';

test.describe('Strona Chat (iframe)', () => {
  test.beforeEach(async ({ page }) => {
    await loginAsAdmin(page);
  });

  test('renderuje iframe z chat.octadecimal.cloud', async ({ page }) => {
    await page.goto('/admin/chat');

    await expect(page).toHaveURL(/\/admin\/chat/);

    const iframe = page.locator('iframe').first();
    await expect(iframe).toBeVisible();
    await expect(iframe).toHaveAttribute('src', /chat\.octadecimal\.cloud/);
  });

  test('pokazuje link "Otworz w nowej karcie"', async ({ page }) => {
    await page.goto('/admin/chat');

    const link = page.getByRole('link', { name: /otworz w nowej karcie/i });
    await expect(link).toBeVisible();
    await expect(link).toHaveAttribute('target', '_blank');
    await expect(link).toHaveAttribute('href', /chat\.octadecimal\.cloud/);
  });

  test('pozycja w nawigacji "Chat (Rocket.Chat)" prowadzi do /admin/chat', async ({ page }) => {
    await page.goto('/admin');
    const navLink = page.getByRole('link', { name: /chat \(rocket\.chat\)/i }).first();
    await expect(navLink).toBeVisible();
    await navLink.click();
    await expect(page).toHaveURL(/\/admin\/chat/);
  });
});
