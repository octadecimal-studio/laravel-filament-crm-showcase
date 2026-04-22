import { test, expect } from '@playwright/test';
import { loginAsAdmin } from './helpers/auth';

test.describe('Wizualna weryfikacja panelu', () => {
  test.beforeEach(async ({ page }) => {
    await loginAsAdmin(page);
  });

  test('dashboard + navigation', async ({ page }) => {
    await page.goto('/admin');
    await page.waitForLoadState('networkidle');
    await page.screenshot({ path: 'test-results/visual-01-dashboard.png', fullPage: true });
  });

  test('strona n8n iframe', async ({ page }) => {
    await page.goto('/admin/n8n');
    await page.waitForLoadState('networkidle');
    // Poczekaj na iframe
    await page.waitForTimeout(3000);
    await page.screenshot({ path: 'test-results/visual-02-n8n.png', fullPage: true });

    // Sprawdz co iframe pokazuje (CF Access login prompt expected)
    const iframe = page.frameLocator('iframe').first();
    const title = await page.locator('iframe').first().getAttribute('src');
    console.log('n8n iframe src:', title);
  });

  test('strona chat iframe', async ({ page }) => {
    await page.goto('/admin/chat');
    await page.waitForLoadState('networkidle');
    await page.waitForTimeout(3000);
    await page.screenshot({ path: 'test-results/visual-03-chat.png', fullPage: true });

    const title = await page.locator('iframe').first().getAttribute('src');
    console.log('chat iframe src:', title);
  });

  test('Workspace nav group expanded', async ({ page }) => {
    await page.goto('/admin');
    await page.waitForLoadState('networkidle');
    // Zoom-in na lewy sidebar
    const sidebar = page.locator('aside, nav').first();
    await sidebar.screenshot({ path: 'test-results/visual-04-sidebar.png' });
  });
});
