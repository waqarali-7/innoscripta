import { Preferences } from "./preferences";

export interface UserProfile {
    id: number;
    name: string;
    email: string;
    is_admin: boolean;
    preferences: Preferences;
    created_at: string;
    updated_at: string;
}