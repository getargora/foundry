BEGIN;

CREATE TABLE IF NOT EXISTS "users" (
    "id" SERIAL PRIMARY KEY CHECK ("id" >= 0),
    "email" VARCHAR(249) UNIQUE NOT NULL,
    "password" VARCHAR(255) NOT NULL,
    "username" VARCHAR(100) DEFAULT NULL,
    "status" SMALLINT NOT NULL DEFAULT '0' CHECK ("status" >= 0),
    "verified" SMALLINT NOT NULL DEFAULT '0' CHECK ("verified" >= 0),
    "resettable" SMALLINT NOT NULL DEFAULT '1' CHECK ("resettable" >= 0),
    "roles_mask" INTEGER NOT NULL DEFAULT '0' CHECK ("roles_mask" >= 0),
    "registered" INTEGER NOT NULL CHECK ("registered" >= 0),
    "last_login" INTEGER DEFAULT NULL CHECK ("last_login" >= 0),
    "force_logout" INTEGER NOT NULL DEFAULT '0' CHECK ("force_logout" >= 0),
    "tfa_secret" VARCHAR(32),
    "tfa_enabled" BOOLEAN DEFAULT false,
    "auth_method" VARCHAR(255) DEFAULT 'password',
    "backup_codes" TEXT,
    "password_last_updated" TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS "users_audit" (
    "user_id" INT NOT NULL,
    "user_event" VARCHAR(255) NOT NULL,
    "user_resource" VARCHAR(255) DEFAULT NULL,
    "user_agent" VARCHAR(255) NOT NULL,
    "user_ip" VARCHAR(45) NOT NULL,
    "user_location" VARCHAR(45) DEFAULT NULL,
    "event_time" TIMESTAMP(3) NOT NULL,
    "user_data" JSONB DEFAULT NULL
);
CREATE INDEX idx_user_event ON users_audit (user_event);
CREATE INDEX idx_user_ip ON users_audit (user_ip);

CREATE TABLE IF NOT EXISTS "users_confirmations" (
    "id" SERIAL PRIMARY KEY CHECK ("id" >= 0),
    "user_id" INTEGER NOT NULL CHECK ("user_id" >= 0),
    "email" VARCHAR(249) NOT NULL,
    "selector" VARCHAR(16) UNIQUE NOT NULL,
    "token" VARCHAR(255) NOT NULL,
    "expires" INTEGER NOT NULL CHECK ("expires" >= 0)
);
CREATE INDEX IF NOT EXISTS "email_expires" ON "users_confirmations" ("email", "expires");
CREATE INDEX IF NOT EXISTS "user_id" ON "users_confirmations" ("user_id");

CREATE TABLE IF NOT EXISTS "users_remembered" (
    "id" BIGSERIAL PRIMARY KEY CHECK ("id" >= 0),
    "user" INTEGER NOT NULL CHECK ("user" >= 0),
    "selector" VARCHAR(24) UNIQUE NOT NULL,
    "token" VARCHAR(255) NOT NULL,
    "expires" INTEGER NOT NULL CHECK ("expires" >= 0)
);
CREATE INDEX IF NOT EXISTS "user" ON "users_remembered" ("user");

CREATE TABLE IF NOT EXISTS "users_resets" (
    "id" BIGSERIAL PRIMARY KEY CHECK ("id" >= 0),
    "user" INTEGER NOT NULL CHECK ("user" >= 0),
    "selector" VARCHAR(20) UNIQUE NOT NULL,
    "token" VARCHAR(255) NOT NULL,
    "expires" INTEGER NOT NULL CHECK ("expires" >= 0)
);
CREATE INDEX IF NOT EXISTS "user_expires" ON "users_resets" ("user", "expires");

CREATE TABLE IF NOT EXISTS "users_throttling" (
    "bucket" VARCHAR(44) PRIMARY KEY,
    "tokens" REAL NOT NULL CHECK ("tokens" >= 0),
    "replenished_at" INTEGER NOT NULL CHECK ("replenished_at" >= 0),
    "expires_at" INTEGER NOT NULL CHECK ("expires_at" >= 0)
);
CREATE INDEX IF NOT EXISTS "expires_at" ON "users_throttling" ("expires_at");

CREATE TABLE IF NOT EXISTS "users_webauthn" (
    "id" SERIAL PRIMARY KEY,
    "user_id" INTEGER NOT NULL,
    "credential_id" BYTEA NOT NULL,
    "public_key" TEXT NOT NULL,
    "attestation_object" BYTEA,
    "sign_count" BIGINT NOT NULL,
    "user_agent" TEXT,
    "created_at" TIMESTAMP(3) WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    "last_used_at" TIMESTAMP(3) WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);
ALTER TABLE "users_webauthn" ADD FOREIGN KEY (user_id) REFERENCES users(id);

CREATE TABLE IF NOT EXISTS "users_contact" (
     "id" SERIAL PRIMARY KEY,
     "user_id" int CHECK ("user_id" >= 0) NOT NULL,
     "type" varchar CHECK ("type" IN ( 'owner','admin','billing','tech','abuse' )) NOT NULL default 'admin',
     "title"   varchar(255) default NULL,
     "first_name"   varchar(255) NOT NULL,
     "middle_name"   varchar(255) default NULL,
     "last_name"   varchar(255) NOT NULL,
     "org"   varchar(255) default NULL,
     "street1"   varchar(255) default NULL,
     "street2"   varchar(255) default NULL,
     "street3"   varchar(255) default NULL,
     "city"   varchar(255) NOT NULL,
     "sp"   varchar(255) default NULL,
     "pc"   varchar(16) default NULL,
     "cc"   char(2) NOT NULL,
     "voice"   varchar(17) default NULL,
     "fax"   varchar(17) default NULL,
     "email"   varchar(255) NOT NULL,
     unique ("user_id", "type") 
);
ALTER TABLE "users_contact" ADD FOREIGN KEY (user_id) REFERENCES users(id);

CREATE TYPE "ticket_status" AS ENUM ('Open', 'In Progress', 'Resolved', 'Closed');
CREATE TYPE "ticket_priority" AS ENUM ('Low', 'Medium', 'High', 'Critical');

CREATE TABLE IF NOT EXISTS "ticket_categories" (
    "id" SERIAL PRIMARY KEY,
    "name" VARCHAR(255) NOT NULL,
    "description" TEXT
);

CREATE TABLE IF NOT EXISTS "support_tickets" (
    "id" SERIAL PRIMARY KEY,
    "user_id" INTEGER NOT NULL, 
    "category_id" INTEGER NOT NULL,
    "subject" VARCHAR(255) NOT NULL,
    "message" TEXT NOT NULL,
    "status" ticket_status DEFAULT 'Open',
    "priority" ticket_priority DEFAULT 'Medium',
    "date_created" TIMESTAMP(3) WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    "last_updated" TIMESTAMP(3) WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);
ALTER TABLE support_tickets ADD FOREIGN KEY ("user_id") REFERENCES users(id) ON DELETE CASCADE;
ALTER TABLE support_tickets ADD FOREIGN KEY ("category_id") REFERENCES ticket_categories(id);
CREATE INDEX idx_support_tickets_date_created ON support_tickets (date_created);

CREATE TABLE IF NOT EXISTS "ticket_responses" (
    "id" SERIAL PRIMARY KEY,
    "ticket_id" INTEGER NOT NULL,
    "responder_id" INTEGER NOT NULL,
    "response" TEXT NOT NULL,
    "date_created" TIMESTAMP(3) WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);
ALTER TABLE ticket_responses ADD FOREIGN KEY ("ticket_id") REFERENCES support_tickets(id);

CREATE TABLE IF NOT EXISTS "invoices" (
     "id" SERIAL PRIMARY KEY,
     "user_id" INT,
     "invoice_number" varchar(25) DEFAULT NULL,
     "billing_contact_id" INT,
     "issue_date" TIMESTAMP(3),
     "due_date" TIMESTAMP(3) DEFAULT NULL,
     "total_amount" NUMERIC(10,2),
     "payment_status" VARCHAR(10) DEFAULT 'unpaid' CHECK (payment_status IN ('unpaid', 'paid', 'overdue', 'cancelled')),
     "notes" TEXT DEFAULT NULL,
     "created_at" TIMESTAMP(3) DEFAULT CURRENT_TIMESTAMP,
     "updated_at" TIMESTAMP(3) DEFAULT CURRENT_TIMESTAMP
);
ALTER TABLE invoices ADD FOREIGN KEY (user_id) REFERENCES users(id);
ALTER TABLE invoices ADD FOREIGN KEY (billing_contact_id) REFERENCES users_contact(id);

COMMIT;
