import { test, expect, Page } from '@playwright/test';
import { loginAsAdmin } from './helpers/auth';

test.beforeEach(async ({ page }) => {
  await loginAsAdmin(page);
});

async function fillAndSave(page: Page, name: string, value: string) {
  await page.getByLabel(name, { exact: false }).first().fill(value);
}

test('CRUD Firmy (Companies)', async ({ page }) => {
  await page.goto('/admin/companies');
  await expect(page.getByRole('heading', { name: /firmy/i })).toBeVisible();

  await page.getByRole('link', { name: /nowa firma|utwórz|new/i }).first().click();
  await expect(page).toHaveURL(/\/admin\/companies\/create/);

  const suffix = Date.now();
  await page.getByLabel('Nazwa', { exact: false }).fill(`Acme Sp. z o.o. ${suffix}`);
  await page.getByLabel('Domena', { exact: false }).fill(`acme-${suffix}.example.com`);
  await page.getByLabel('Branża', { exact: false }).fill('IT');
  await page.getByLabel('Kraj', { exact: false }).fill('PL');

  await page.getByRole('button', { name: /zapisz|utwórz|create|save/i }).first().click();
  await expect(page).toHaveURL(/\/admin\/companies\/\d+/);
  await expect(page.getByText(`Acme Sp. z o.o. ${suffix}`).first()).toBeVisible();
});

test('CRUD Kontakty (Contacts)', async ({ page }) => {
  await page.goto('/admin/contacts');
  await expect(page.getByRole('heading', { name: /kontakty/i })).toBeVisible();

  await page.getByRole('link', { name: /nowy kontakt|utwórz|new/i }).first().click();
  const suffix = Date.now();
  await page.getByLabel('Imię', { exact: false }).first().fill('Jan');
  await page.getByLabel('Nazwisko', { exact: false }).first().fill(`Kowalski${suffix}`);
  await page.getByLabel('Email', { exact: false }).fill(`jan${suffix}@example.com`);

  await page.getByRole('button', { name: /zapisz|utwórz|create|save/i }).first().click();
  await expect(page).toHaveURL(/\/admin\/contacts\/\d+/);
  await expect(page.getByText(`Kowalski${suffix}`).first()).toBeVisible();
});

test('CRUD Szanse (Opportunities)', async ({ page }) => {
  await page.goto('/admin/opportunities');
  await expect(page.getByRole('heading', { name: /szanse/i })).toBeVisible();

  await page.getByRole('link', { name: /nowa szansa|utwórz|new/i }).first().click();
  const suffix = Date.now();
  await page.getByLabel('Nazwa', { exact: false }).fill(`Projekt ${suffix}`);
  await page.getByLabel('Kwota', { exact: false }).fill('10000');

  await page.getByRole('button', { name: /zapisz|utwórz|create|save/i }).first().click();
  await expect(page).toHaveURL(/\/admin\/opportunities\/\d+/);
  await expect(page.getByText(`Projekt ${suffix}`).first()).toBeVisible();
});

test('CRUD Zadania (CrmTasks)', async ({ page }) => {
  await page.goto('/admin/crm-tasks');
  await expect(page.getByRole('heading', { name: /zadania/i })).toBeVisible();

  await page.getByRole('link', { name: /nowe zadanie|utwórz|new/i }).first().click();
  const suffix = Date.now();
  await page.getByLabel('Tytuł', { exact: false }).fill(`Zadanie testowe ${suffix}`);

  await page.getByRole('button', { name: /zapisz|utwórz|create|save/i }).first().click();
  await expect(page).toHaveURL(/\/admin\/crm-tasks\/\d+/);
  await expect(page.getByText(`Zadanie testowe ${suffix}`).first()).toBeVisible();
});

test('CRUD Notatki (CrmNotes)', async ({ page }) => {
  await page.goto('/admin/crm-notes');
  await expect(page.getByRole('heading', { name: /notatki/i })).toBeVisible();

  await page.getByRole('link', { name: /nowa notatka|utwórz|new/i }).first().click();
  const suffix = Date.now();
  await page.getByLabel('Treść', { exact: false }).fill(`Testowa notatka ${suffix}`);

  await page.getByRole('button', { name: /zapisz|utwórz|create|save/i }).first().click();
  await expect(page).toHaveURL(/\/admin\/crm-notes\/\d+/);
  await expect(page.getByText(`Testowa notatka ${suffix}`).first()).toBeVisible();
});
