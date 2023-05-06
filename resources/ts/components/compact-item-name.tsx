import classNames from "classnames";
import { Phase } from "@/types/items";

const phaseColor: Record<string, string> = {
  'Ruby': 'text-red-500',
  'Emerald': 'text-green-500',
  'Sapphire': 'text-blue-500',
  'Black Pearl': 'text-violet-500',
}

const phaseClass = (phase: Phase) => classNames([
  'ml-2',
  phaseColor[phase] || 'text-gray-400'
]);

interface Props {
  name: string;
  exterior: string | null;
  phase: Phase | null;
  isStattrak: boolean;
}

export default function CompactItemName({ name, exterior, phase, isStattrak }: Props) {
  return (
    <span className="align-middle text-xs">
      <span className="dark:text-gray-200">
        {name}
      </span>
      {exterior && (
        <span className="ml-2 text-gray-400">
          {exterior}
        </span>
      )}
      {isStattrak && (
        <span className="ml-2 text-orange-400">
          ST
        </span>
      )}
      {phase && (
        <span className={phaseClass(phase)}>
          {phase}
        </span>
      )}
    </span>
  );
}