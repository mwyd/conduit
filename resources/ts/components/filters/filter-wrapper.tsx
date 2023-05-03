import { ReactNode } from "react";

interface Props {
  title: string;
  children: ReactNode;
}

export default function FilterWrapper({ title, children }: Props) {
  return (
    <div className="text-sm">
      <label className="font-semibold mb-2 block">
        {title}
      </label>
      {children}
    </div>
  );
}