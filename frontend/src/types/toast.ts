export type ToastType = "info" | "success" | "warning" | "error" | "danger";
export interface Toast {
    message: string;
    type: "success" | "danger" | "warning" | "error" | "info";
    duration?: number;
}