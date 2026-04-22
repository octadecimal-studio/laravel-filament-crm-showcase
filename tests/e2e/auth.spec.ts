import { test, expect } from '@playwright/test';
import { loginAsAdmin } from './helpers/auth';

test('logowanie admin do panelu', async ({ page }) => {
  await loginAsAdmin(page);
  await expect(page).toHaveURL(/\/admin\/?$/);
  await expect(page.getByRole('heading', { level: 1 })).toBeVisible();
});
