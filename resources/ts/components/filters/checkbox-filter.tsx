interface Props {
  label: string;
  value: boolean;
  onChange: () => void;
}

export default function CheckboxFilter({ label, value, onChange }: Props) {
  return (
    <label>
      <input
        type="checkbox"
        checked={value}
        onChange={onChange}
      />
      <span className="ml-2">
        {label}
      </span>
    </label>
  );
}